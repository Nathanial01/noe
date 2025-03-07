<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\UserRolesEnum;
use OpenApi\Annotations\Webhook;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Http;
use App\Enums\CompanyEnums\StatusEnum;
use App\Enums\Webhook\WebhookTypeEnum;
use MongoDB\Laravel\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Company extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $connection = 'mongodb';
    protected $collection = 'companies';
    protected $fillable = [
        'name',
        'city',
        'street',
        'house_number',
        'house_number_addition',
        'postal_code',
        'branding_name',
        'branding_city',
        'branding_street',
        'branding_house_number',
        'branding_house_number_addition',
        'branding_postal_code',
        'wl_footer',
        'kvk_number',
        'vat_number',
        'credit_amount',
        'promotional_code',
        'status',
        'renewal_mail_sent',
        'billing_expiration_date',
        'phone_number',
        'disclaimer_title',
        'disclaimer_text',
        'show_company_info',
        'imported_csv',
        'api_active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'house_number' => 'integer',
        'kvk_number' => 'integer',
        'credit_amount' => 'integer',
        'billing_expiration_date' => 'date',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('role', 'reference', 'status', 'blocked_date');
    }

    public function owners(): BelongsToMany
    {
        return $this->users()->wherePivot('role', '=', UserRolesEnum::Owner);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function invites(): HasMany
    {
        return $this->hasMany(Invite::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class, 'company_id');
    }

    public function complexes(): HasMany
    {
        return $this->hasMany(Complex::class, 'company_id');
    }

    public function apiKeys(): HasMany
    {
        return $this->hasMany(ApiKey::class);
    }

    public function hasPermission(User $user): bool
    {
        return $this->users()
            ->where('user_id', $user->id)
            ->exists();
    }

    public function expiredSubscription(): bool
    {
        return is_null($this->billing_expiration_date) ? false : (Carbon::parse($this->billing_expiration_date) < Carbon::now());
    }

    public function getAddressAttribute()
    {
        if (isset($this->house_number_addition)) {
            return $this->street . ' ' . $this->house_number . $this->house_number_addition;
        }
        return $this->street . ' ' . $this->house_number;
    }

    public function getBrandingAdressAttribute()
    {
        if (isset($this->branding_house_number_addition)) {
            return $this->branding_street . ' ' . $this->branding_house_number . $this->branding_house_number_addition;
        }
        return $this->branding_street . ' ' . $this->branding_house_number;
    }

    public function hasNecessarySubscription(): bool
    {
        return $this->getAttribute('status') === StatusEnum::Professional || $this->getAttribute('status') === StatusEnum::ProfessionalXL || $this->getAttribute('status') === StatusEnum::Unlimited || $this->getAttribute('status') === StatusEnum::Whitelabel;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('company-logo')->acceptsMimeTypes(['image/jpeg', 'image/png']);
        $this->addMediaCollection('property-imports');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('400')
            ->width(400);
    }

    public function addCredits($credit_amount): bool
    {
        $this->credit_amount = $this->credit_amount + $credit_amount;

        $this->save();

        return true;
    }

    public function removeCredits($credit_amount): bool
    {
        $this->credit_amount = $this->credit_amount - $credit_amount;

        $this->save();

        return true;
    }

    public function isMinStandard(): bool
    {
        return !is_null($this->status);
    }

    public function isMinPremium(): bool
    {
        return  $this->status == StatusEnum::Premium || $this->status == StatusEnum::Professional || $this->status == StatusEnum::ProfessionalXL || $this->status == StatusEnum::Unlimited || $this->status == StatusEnum::Whitelabel;
    }

    public function isMinProfessional(): bool
    {
        return $this->status == StatusEnum::Professional || $this->status == StatusEnum::ProfessionalXL || $this->status == StatusEnum::Unlimited || $this->status == StatusEnum::Whitelabel;
    }

    public function isWhiteLabel(): bool
    {
        return $this->status == StatusEnum::Whitelabel;
    }

    public function getPropertyWithReference(string $reference): Property|null
    {
        return $this->properties()->where('reference', $reference)->first();
    }

    public function makeWebhookCall(Check $check, $key, WebhookTypeEnum $type): void
    {
        $webhook_info = $key->getWebhookInfo();

        $body = [
            'type' => $type->value,
            'period' => Str::after($check->formattedPeriod, 'Periode '),
            'reference' => $check->property->reference,
            'points' => $check->points,
            'price' => intval($check->price * 100),
            'pdf_url' => $check->getApiPdfUrl(),
            'overview_url' => $check->getApiOverviewUrl(),
            'woz' => $check->property->wozs->map(function (Woz $woz) {
                return [
                    'date' => $woz->reference_date,
                    'value' => intval($woz->determined_value * 100),
                ];
            })->toArray(),
        ];

        $signatureHash = hash_hmac('sha256', json_encode($body), $webhook_info['secret']);
        $url = $webhook_info['url'];

        Http::withHeaders([
            'X-Verification-hash' => $signatureHash,
        ])->post($url, $body);
    }

    public function hasUser(User $user): bool
    {
        return $this->users()->where('user_id', $user->id)->exists();
    }

    public function hasProperty(Property $property): bool
    {
        return $this->properties()->where('id', $property->id)->exists();
    }

    public function hasPortfolio(Portfolio $portfolio): bool
    {
        return $this->portfolios()->where('id', $portfolio->id)->exists();
    }

    public function hasComplex(Complex $complex): bool
    {
        return $this->complexes()->where('id', $complex->id)->exists();
    }
}

<?php
namespace App\Models;

use Carbon\Carbon;
use App\Enums\UserRolesEnum;
use OpenApi\Annotations\Webhook;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Http;
use App\Enums\CompanyEnums\StatusEnum;
use App\Enums\Webhook\WebhookTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use App\Models\User; // ✅ Fix: Use the correct User model

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

    protected $casts = [
        'id' => 'integer',
        'house_number' => 'integer',
        'kvk_number' => 'integer',
        'credit_amount' => 'integer',
        'billing_expiration_date' => 'date',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('role', 'reference', 'status', 'blocked_date'); // ✅ Fix: Use User model
    }

    public function owners(): BelongsToMany
    {
        return $this->users()->wherePivot('role', '=', UserRolesEnum::Owner);
    }

    public function hasUser(User $user): bool
    {
        return $this->users()->where('user_id', $user->id)->exists(); // ✅ Fix: Use User model
    }

    public function hasPermission(User $user): bool
    {
        return $this->users()
            ->where('user_id', $user->id)
            ->exists(); // ✅ Fix: Use User model
    }
}

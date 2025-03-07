<?php

namespace App\Models;

use App\Traits\PeriodTrait;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Enums\PropertyEnums\PropertyTypeEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\PropertyEnums\PropertyStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\App;

class Property extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, PeriodTrait;

    protected $fillable = [
        'city',
        'street',
        'municipality',
        'house_number',
        'house_number_addition',
        'house_letter',
        'postal_code',
        'type',
        'construction_year',
        'number_designation',
        'current_rental_price',
        'csv_imported',
        'company_id',
        'latitude',
        'longitude',
        'avatar',
        'reference',
        'label_expiration_date',
        'label_registration_date',
        'energy_index',
        'energy_label',
        'api',
        'status',
    ];

    protected $casts = [
        'id' => 'integer',
        'house_number' => 'integer',
        'company_id' => 'integer',
        'api' => 'boolean',
    ];

    public function setReferenceAttribute($value)
    {
        if ($this->exists && $this->api && $this->reference !== $value) {
            throw new \Exception('Cannot modify reference for properties created via API');
        }
        $this->attributes['reference'] = $value;
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function checks(): HasMany
    {
        return $this->hasMany(Check::class);
    }

    public function wozs(): HasMany
    {
        return $this->hasMany(Woz::class);
    }

    public function checkJob(): HasOne
    {
        return $this->hasOne(CheckJob::class);
    }

    public function portfolios(): BelongsToMany
    {
        return $this->belongsToMany(Portfolio::class);
    }

    public function complexes(): BelongsToMany
    {
        return $this->belongsToMany(Complex::class)->withTimestamps();
    }

    public function hasPermission($company): bool
    {
        return $this->company_id === $company->id;
    }

    public function getWozAttribute()
    {
        $check = $this->latestCheck()->first();
        if ($check->dependentProperty()->exists()) {
            return '€ ' . number_format($check->dependentProperty()->first()->woz, 2, ',', '.');
        } elseif ($check->independentProperty()->exists()) {
            return '€ ' . number_format($check->independentProperty()->first()->woz, 2, ',', '.');
        }
        return '-';
    }

    public function getEstablishedAttribute()
    {
        $check = $this->latestCheck()->first();
        if ($check->dependentProperty()->exists()) {
            return $check->dependentProperty()->first()->established ? 'Vastgesteld' : 'Geschat';
        } elseif ($check->independentProperty()->exists()) {
            return $check->independentProperty()->first()->established ? 'Vastgesteld' : 'Geschat';
        }
        return '-';
    }

    public function getEstablishedAtAttribute()
    {
        $check = $this->latestCheck()->first();
        if ($check->dependentProperty()->exists()) {
            return $check->dependentProperty()->first()->established_at_formatted ?? '-';
        } elseif ($check->independentProperty()->exists()) {
            return $check->independentProperty()->first()->established_at_formatted ?? '-';
        }
        return '-';
    }

    public function hasProtectedRights($check)
    {
        $period = $this->periodString($check);
        if (in_array($period, config('check-versions.version-1'))) {
            return $this->type === PropertyTypeEnum::ProtectedCityView && $this->construction_year < 1945;
        } elseif (in_array($period, config('check-versions.version-2'))) {
            return ($this->type === PropertyTypeEnum::NationalMonument && !$check->pre_juli_contract) || $this->type === PropertyTypeEnum::MunicipalityMonument || ($this->type === PropertyTypeEnum::ProtectedCityView && $this->construction_year < 1965);
        }
        return false;
    }

    public function hasNewConstructionRights($check)
    {
        $period = $this->periodString($check);
        return $this->construction_year < 2028
            && $check->new_construction_raise
            && $check->points >= 144
            && $check->points <= 186;
    }

    public function hasMonumentRights()
    {
        return $this->type === PropertyTypeEnum::NationalMonument || $this->type === PropertyTypeEnum::MunicipalityMonument;
    }

    public function getAddressAttribute()
    {
        return $this->street . ' ' . $this->house_number . ($this->house_letter ? '' . $this->house_letter : '') . ($this->house_number_addition ? '-' . $this->house_number_addition : '');
    }

    public function getFullAddressAttribute()
    {
        return $this->street . ' ' . $this->house_number . ($this->house_letter ? '' . $this->house_letter : '') . ($this->house_number_addition ? '-' . $this->house_number_addition : '') . ', ' . $this->city;
    }

    public function getFullSentenceAddressAttribute()
    {
        return $this->street . ' ' . $this->house_number . ($this->house_letter ? '' . $this->house_letter : '') . ($this->house_number_addition ? '-' . $this->house_number_addition : '') . ' te ' . $this->city;
    }

    public function getFullTownAddressAttribute()
    {
        return str_replace(' ', '+', "{$this->street} {$this->house_number}{$this->house_number_addition} {$this->city}");
    }

    public function latestCheck(): HasOne
    {
        return $this->hasOne(Check::class)->latestOfMany();
    }

    public function currentCheck(): HasOne
    {
        if(now()->year === 2024) {
            return $this->hasOne(Check::class)->where('start_date', '2024-07-01')->where('end_date', '2024-12-31')->latest();
        }
        return $this->hasOne(Check::class)->where('start_date', '2025-01-01')->where('end_date', '2025-12-31')->latest();
    }

    public function getLatestOrCurrent()
    {
        return !is_null($this->currentCheck) ? $this->currentCheck : $this->latestCheck;
    }


    public function getMediaPath(): string
    {
        return "property/{$this->id}";
    }

    public function getAvatarAttribute(?string $value)
    {
        $media = $this->getMedia('property-avatar');
        if ($media->count() > 0) {
            return $media[0]->getUrl('avatar');
        } else if(App::runningUnitTests()) {
            return 'http://localhost/' . ($value ?? '/default/property-avatar.png');
        } else {
            return Storage::disk('gcs')->url($value ?? '/default/property-avatar.png');
        }
    }

    public function getMapImageAttribute(?string $value): string
    {
        return Storage::disk('gcs')->url($value ?? '/default/property-map.png');
    }

    public function getPropertyKindAttribute()
    {
        if ($this->checks->first() == null) {
            return '-';
        }
        if ($this->checks->first()->dependentProperty()->exists() || $this->checks->first()->dependentPropertyVTwo()->exists()) {
            return "Onzelfstandig";
        } elseif ($this->checks->first()->independentProperty()->exists()) {
            return "Zelfstandig";
        }
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('extraFiles')->acceptsMimeTypes([
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/pdf',
            'image/jpg',
            'image/jpeg',
            'image/png',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/csv'
        ]);

        $this->addMediaCollection('property-avatar')->acceptsMimeTypes(['image/jpeg', 'image/png']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('avatar')
            ->performOnCollections('property-avatar')
            ->width(640)
            ->height(600);
    }

    public function getLatestWoz()
    {
        return $this->wozs()->orderBy('reference_date', 'desc')->first();
    }

    public function getFormattedCurrentRentalPriceAttribute()
    {
        return '€ ' . number_format($this->current_rental_price, 2, ',', '.');
    }

    public function scopeActive($query)
    {
        $query->where('status', PropertyStatusEnum::ACTIVE);
    }

    public function getEnergyLabelRegistrationStatusAttribute()
    {
        if (is_null($this->label_registration_date)) {
            return 'Ongeldig';
        }
        return (Carbon::parse($this->label_registration_date) < Carbon::parse('2021-01-01') && $this->energy_index == null) ? 'Ongeldig' : 'Geldig';
    }
}

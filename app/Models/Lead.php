<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable; // Using the MongoDB auth base
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Lead extends Authenticatable implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia;

    // Use the MongoDB connection
    protected $connection = 'mongodb';

    // Specify the MongoDB collection name (defaults to 'leads' if not set)
    protected string $collection = 'leads';

    protected $fillable = [
        'email',
        'phone_number',
        'current_rental_price',
        'owner_type',
        'building_type',
        'surface',
        'number_designation',
        'construction_year',
        'municipality',
        'city',
        'street',
        'postal_code',
        'house_number',
        'house_letter',
        'house_number_addition',
        'woz_info',
        'approximated_woz',
        'label_expiration_date',
        'label_registration_date',
        'energy_index',
        'energy_label',
        'longitude',
        'latitude',
        'avatar',
    ];

    public function getAddressAttribute()
    {
        return $this->street.' '.$this->house_number.
            ($this->house_letter ? ' '.$this->house_letter : '').
            ($this->house_number_addition ? '-'.$this->house_number_addition : '');
    }

    public function getFullAddressAttribute()
    {
        return "$this->street $this->house_number$this->house_letter".
            ($this->house_number_addition ? '-'.$this->house_number_addition : '').
            ", $this->postal_code $this->city";
    }

    public function getMediaPath(): string
    {
        return "lead/{$this->id}";
    }

    public function getAvatarAttribute(?string $value)
    {
        $media = $this->getMedia('lead-avatar');
        if ($media->count() > 0) {
            return $media[0]->getUrl('avatar');
        } else {
            return Storage::disk('gcs')->url($value ?? '/default/property-avatar.png');
        }
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('lead-avatar')
            ->acceptsMimeTypes(['image/jpeg', 'image/png']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('avatar')
            ->performOnCollections('property-avatar')
            ->width(640)
            ->height(600);
    }
}

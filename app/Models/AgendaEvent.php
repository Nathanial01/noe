<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AgendaEvent extends Model
{
    use HasFactory;

    // Use the MongoDB connection and collection.
    protected $connection = 'mongodb';
    protected $collection = 'agendas_event';

    // Configure MongoDB primary key settings.
    protected $primaryKey = '_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'title',
        'start_daytime',
        'end_daytime',
        'place',
        'location',
        'description',
        'event_url', // Registration URL for the event
        'cancelled'
    ];

    protected $casts = [
        'start_daytime' => 'datetime',
        'end_daytime'   => 'datetime',
        'cancelled'     => 'boolean',
    ];

    // Append computed attributes so they appear in JSON responses.
    protected $appends = [
        'start_date', 'start_time', 'end_date', 'end_time', 'status', 'map_embed', 'event_link'
    ];

    /**
     * Return the start date as a string.
     */
    public function getStartDateAttribute(): ?string
    {
        return $this->start_daytime
            ? Carbon::parse($this->start_daytime)->startOfDay()->toDateString()
            : null;
    }

    /**
     * Return the start time as a formatted string (HH:MM).
     */
    public function getStartTimeAttribute(): ?string
    {
        return $this->start_daytime
            ? Carbon::parse($this->start_daytime)->format('H:i')
            : null;
    }

    /**
     * Return the end date as a string.
     */
    public function getEndDateAttribute(): ?string
    {
        return $this->end_daytime
            ? Carbon::parse($this->end_daytime)->startOfDay()->toDateString()
            : null;
    }

    /**
     * Return the end time as a formatted string (HH:MM).
     */
    public function getEndTimeAttribute(): ?string
    {
        return $this->end_daytime
            ? Carbon::parse($this->end_daytime)->format('H:i')
            : null;
    }

    public function setStartDateAttribute($value): void
    {
        // Combine with the current start_time if available or default.
        $time = $this->start_time ?? '00:00';
        $this->attributes['start_daytime'] = Carbon::parse($value . ' ' . $time);
    }

    public function setStartTimeAttribute($value): void
    {
        $date = $this->start_date ?? now()->format('Y-m-d');
        $this->attributes['start_daytime'] = Carbon::parse($date . ' ' . $value);
    }

    public function setEndDateAttribute($value): void
    {
        $time = $this->end_time ?? '00:00';
        $this->attributes['end_daytime'] = Carbon::parse($value . ' ' . $time);
    }

    public function setEndTimeAttribute($value): void
    {
        $date = $this->end_date ?? now()->format('Y-m-d');
        $this->attributes['end_daytime'] = Carbon::parse($date . ' ' . $value);
    }

    /**
     * Return the event status.
     */
    public function getStatusAttribute(): string
    {
        if ($this->cancelled) {
            return 'geannuleerd';
        }
        if ($this->start_date && Carbon::parse($this->start_date)->gte(now())) {
            return 'gepland';
        }
        return 'afgelopen';
    }

    /**
     * Dynamically generate the Google Maps embed URL.
     */
    public function getMapEmbedAttribute(): ?string
    {
        if (!empty($this->location)) {
            $formattedLocation = urlencode($this->location);
            $apiKey = config('services.google.javascript_maps');
            return "https://www.google.com/maps/embed/v1/place?q={$formattedLocation}&key={$apiKey}";
        }
        return null;
    }

    /**
     * Return the event link (registration URL).
     */
    public function getEventLinkAttribute(): ?string
    {
        return $this->event_url;
    }
}

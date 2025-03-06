<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AgendaEvent extends Model
{
    use HasFactory;

    protected $table = 'agendas_event';

    // Include the new 'event_url' attribute:
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


    /**
     * Accessor: Return the start date as a Carbon instance.
     * (Nova’s Date field requires a Carbon/DateTime instance.)
     */
    public function getStartDateAttribute(): ?Carbon
    {
        return $this->start_daytime ? Carbon::parse($this->start_daytime)->startOfDay() : null;
    }

    /**
     * Accessor: Return the start time as a formatted string (HH:MM).
     */
    public function getStartTimeAttribute(): ?string
    {
        return $this->start_daytime ? Carbon::parse($this->start_daytime)->format('H:i') : null;
    }

    /**
     * Accessor: Return the end date as a Carbon instance.
     */
    public function getEndDateAttribute(): ?Carbon
    {
        return $this->end_daytime ? Carbon::parse($this->end_daytime)->startOfDay() : null;
    }

    /**
     * Accessor: Return the end time as a formatted string (HH:MM).
     */
    public function getEndTimeAttribute(): ?string
    {
        return $this->end_daytime ? Carbon::parse($this->end_daytime)->format('H:i') : null;
    }


    public function setStartDateAttribute($value): void
    {
        $time = $this->start_time ?? '00:00';
        $this->attributes['start_daytime'] = Carbon::parse($value . ' ' . $time);
    }

    public function setStartTimeAttribute($value): void
    {
        $date = $this->start_date ? $this->start_date->format('Y-m-d') : now()->format('Y-m-d');
        $this->attributes['start_daytime'] = Carbon::parse($date . ' ' . $value);
    }

    public function setEndDateAttribute($value): void
    {
        $time = $this->end_time ?? '00:00';
        $this->attributes['end_daytime'] = Carbon::parse($value . ' ' . $time);
    }

    public function setEndTimeAttribute($value): void
    {
        $date = $this->end_date ? $this->end_date->format('Y-m-d') : now()->format('Y-m-d');
        $this->attributes['end_daytime'] = Carbon::parse($date . ' ' . $value);
    }


    /**
     * Accessor: Return the event status.
     */
    public function getStatusAttribute(): string
    {
        return $this->cancelled
            ? 'geannuleerd'
            : ($this->start_date->gte(now()) ? 'gepland' : 'afgelopen');
    }

    /**
     * Accessor: Dynamically generate the Google Maps embed URL based on the location.
     * It removes commas, replaces spaces with '+', and appends your API key.
     *
     * @return string|null
     */
    public function getMapEmbedAttribute(): ?string
    {
        if (!empty($this->location)) {
            $formattedLocation = Str::replace([',', ' '], ['', '+'], $this->location);
            $apiKey = config('services.google.javascript_maps');
            return "https://www.google.com/maps/embed/v1/place?q={$formattedLocation}&key={$apiKey}";
        }
        return null;
    }

    /**
     * Accessor: Return the event link (registration URL) dynamically.
     *
     * This simply returns the stored event_url. You can add further logic here
     * if you need to process or validate the URL.
     *
     * @return string|null
     */
    public function getEventLinkAttribute(): ?string
    {
        return $this->event_url;
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use MongoDB\Laravel\Eloquent\Model;
use App\Traits\PeriodTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\SoftDeletes as MongoSoftDeletes;
use Jenssegers\Mongodb\Relations\HasOne;
use Jenssegers\Mongodb\Relations\HasMany;
use Jenssegers\Mongodb\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Check extends Model
{
    use HasFactory, MongoSoftDeletes, PeriodTrait;

    protected $connection = 'mongodb'; // Verplicht voor MongoDB

    protected $collection = 'checks'; // Optioneel, als de collection een andere naam heeft dan de model naam

    protected $fillable = [
        'version',
        'points',
        'price',
        'questions',
        'property_id',
        'user_id',
        'start_date',
        'end_date',
        'pre_juli_contract',
        'new_construction_raise',
        'finished_at',
        'is_trial_calc',
        'duplication_finished',
        'api_pdf_url',
        'status',
        'path'
    ];

    protected $casts = [
        'questions'   => 'array',
        'start_date'  => 'datetime',
        'end_date'    => 'datetime',
        'finished_at' => 'datetime',
    ];

    protected $touches = ['property'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function extraFacilities(): HasMany
    {
        return $this->hasMany(ExtraFacility::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function areas(): HasMany
    {
        return $this->hasMany(Area::class);
    }

    public function dependentProperty(): HasOne
    {
        return $this->hasOne(DependentProperty::class);
    }

    public function dependentPropertyVTwo(): HasOne
    {
        return $this->hasOne(DependentPropertyVTwo::class);
    }

    public function independentProperty(): HasOne
    {
        return $this->hasOne(IndependentProperty::class);
    }

    public function hasPermission($property): bool
    {
        return $this->property_id === $property->_id; // MongoDB gebruikt `_id` in plaats van `id`
    }

    public function propertyType(): string
    {
        if ($this->independentProperty()->exists()) {
            return 'Zelfstandig';
        } else {
            return 'Onzelfstandig';
        }
    }

    public function getStatusColorAttribute()
    {
        return [
            'editing' => 'orange',
            'finished' => 'green',
        ][$this->status] ?? 'cool-gray';
    }

    public function getStatusAttribute($value)
    {
        return trans('status.' . $value);
    }

    public function getFormattedPriceAttribute(): string
    {
        $price = $this->price;
        $points = $this->points;
        if ($this->periodString($this) === 'test-period') {
            return 'Proef berekening';
        }
        if (in_array($this->periodString($this), config('check-versions.version-2'))) {
            if ($points > 250) {
                return 'Vrije sector';
            }
        }
        if (is_null($price)) {
            return 'Nog niet afgerond';
        } else if ($price == 0.00) {
            return 'Vrije sector';
        }

        return '€ ' . number_format($price, 2, ',', '.');
    }

    public function getFormattedPeriodAttribute(): string
    {
        if ($this->periodString($this) == 'test-period') {
            return 'Proefberekening middenhuur';
        }
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);
        return 'Periode ' . $start_date->format('d-m-Y') . ' tot ' . $end_date->format('d-m-Y');
    }

    public function getFormattedFinalPriceAttribute(): string
    {
        $point = Points::where('points', round($this->points))
            ->where('end_date', '=', $this->end_date)
            ->where('start_date', '=', $this->start_date)
            ->first();
        $price = floatval($this->price);

        if ($this->periodString($this) == 'test-period') {
            return 'Proefberekening middenhuur';
        }
        if (in_array($this->periodString($this), config('check-versions.version-2'))) {
            if ($this->points > 250) {
                return 'Vrije sector';
            }
        }
        if ($this->points > 750) {
            return 'Vrije sector';
        }

        if ($point != null) {
            if (!$point->advice && $price == 0.00) {
                return 'n.v.t.';
            }
            return $point->advice && $price != 0.00 ? "Vrije sector (advies: € " . number_format($price, 2, ',', '.') . ")" : ($price == 0.00 ? 'Vrije sector' : '€ ' . number_format($price, 2, ',', '.'));
        }

        if ($this->points === 0) {
            return 'n.v.t.';
        }
        return 'Proef berekening';
    }

    public function getApiPdfUrl(): string|null
    {
        if (!$this->api_pdf_url || !Storage::disk('gcs')->exists($this->api_pdf_url)) {
            return null;
        }

        return Storage::disk('gcs')->temporaryUrl($this->api_pdf_url, now()->addMinutes(10));
    }

    public function hasArea(Area $area): bool
    {
        return $this->areas()->where('_id', $area->_id)->exists();
    }

    public function hasDependentProperty(): bool
    {
        return $this->dependentProperty()->exists();
    }

    public function hasIndependentProperty(): bool
    {
        return $this->independentProperty()->exists();
    }

    public function hasDependentPropertyVTwo(): bool
    {
        return $this->dependentPropertyVTwo()->exists();
    }

    public function getApiOverviewUrl(): string|null
    {
        return route('app.property.show.overview', [
            'company' => $this->property->company->_id,
            'property' => $this->property->_id
        ]);
    }
}

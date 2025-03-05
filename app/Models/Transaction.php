<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'mollie_id',
        'credit_amount',
        'subtotal',
        'payment_amount',
        'product_description',
        'status',
        'vat',
        'invoice_number',
        'payment_method',
        'is_subscription',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function getStatusColorAttribute()
    {
        return [
            'Aangemaakt' => 'orange',
            'Betaald' => 'green',
            'Gefaald' => 'red',
            'Vervallen' => 'red',
            'Afgebroken' => 'red',
        ][$this->status] ?? 'cool-gray';
    }

    public function getStatusAttribute($value)
    {
        return trans('status.payments.' . $value);
    }

    public function getUserNameAttribute()
    {
        $user =  User::find($this->user_id);
        return $user->name;
    }

    public function getCompanyNameAttribute()
    {
        $company =  Company::find($this->company_id);
        return $company->name;
    }

    public function scopePaid(Builder $query): void
    {
        $query->where('status', 'paid');
    }
}

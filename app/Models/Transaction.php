<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Transaction extends Authenticatable
{
    use HasFactory;

    // Use the MongoDB connection
    protected $connection = 'mongodb';

    // Specify the collection name if needed (defaults to "transactions" if not set)
    protected $collection = 'transactions';

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

    /**
     * Get the user associated with the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the company associated with the transaction.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Accessor for status color.
     */
    public function getStatusColorAttribute()
    {
        return [
            'Aangemaakt' => 'orange',
            'Betaald'    => 'green',
            'Gefaald'    => 'red',
            'Vervallen'  => 'red',
            'Afgebroken' => 'red',
        ][$this->status] ?? 'cool-gray';
    }

    /**
     * Accessor for status.
     */
    public function getStatusAttribute($value)
    {
        return trans('status.payments.' . $value);
    }

    /**
     * Accessor to retrieve the user's name.
     */
    public function getUserNameAttribute()
    {
        $user = User::find($this->user_id);
        return $user ? $user->name : null;
    }

    /**
     * Accessor to retrieve the company's name.
     */
    public function getCompanyNameAttribute()
    {
        $company = Company::find($this->company_id);
        return $company ? $company->name : null;
    }

    /**
     * Scope a query to only include paid transactions.
     */
    public function scopePaid(Builder $query): void
    {
        $query->where('status', 'paid');
    }
}

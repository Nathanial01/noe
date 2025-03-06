<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'nationality',
        'country_of_residence',
        'gender',
        'marital_status',
        'email',
        'phone',
        'residential_address',
        'government_id',
        'tax_id',
        'social_security_number',
        'proof_of_address',
        'employment_status',
        'source_of_income',
        'annual_income_range',
        'net_worth',
        'investment_experience',
        'risk_tolerance',
        'investment_objectives',
        'terms_agreed',
        'privacy_policy_consented',
        'risk_disclosure_agreed',
        'tax_form',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_admin'          => 'boolean',
    ];

    /**
     * Accessor for full name.
     */
    public function getNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}

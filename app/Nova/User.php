<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        // Personal Information
        'first_name',
        'last_name',
        'date_of_birth',
        'nationality',
        'country_of_residence',
        'gender',
        'marital_status',

        // Contact Details
        'email',
        'phone',
        'residential_address',

        // Government & Legal Identification (KYC)
        'government_id',
        'tax_id',
        'social_security_number',
        'proof_of_address',

        // Financial Information & Investment Profile
        'employment_status',
        'source_of_income',
        'annual_income_range',
        'net_worth',
        'investment_experience',
        'risk_tolerance',
        'investment_objectives',

        // Regulatory Agreements & Declarations
        'terms_agreed',
        'privacy_policy_consented',
        'risk_disclosure_agreed',
        'tax_form',

        // Authentication & Timestamps
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for arrays and JSON.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native or custom types.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            // Laravel 10+ “hashed” casting for the password.
            'password' => 'hashed',

            // Boolean fields
            'terms_agreed' => 'boolean',
            'privacy_policy_consented' => 'boolean',
            'risk_disclosure_agreed' => 'boolean',
            'is_admin' => 'boolean',

            // Decimal fields (with two decimal places)
            'net_worth' => 'decimal:2',
        ];
    }
}

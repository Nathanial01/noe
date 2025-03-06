<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'first_name'            => $this->faker->firstName,
            'last_name'             => $this->faker->lastName,
            'date_of_birth'         => $this->faker->date(),
            'nationality'           => $this->faker->country,
            'country_of_residence'  => $this->faker->country,
            'gender'                => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'marital_status'        => $this->faker->randomElement(['single', 'married', 'divorced', 'widowed']),
            'email'                 => $this->faker->unique()->safeEmail,
            'phone'                 => $this->faker->phoneNumber,
            'residential_address'   => $this->faker->address,
            'government_id'         => $this->faker->uuid,
            'tax_id'                => $this->faker->numerify('##########'),
            'social_security_number'=> $this->faker->numerify('###-##-####'),
            'proof_of_address'      => null,
            'employment_status'     => $this->faker->randomElement(['employed', 'self-employed', 'retired', 'student', 'unemployed']),
            'source_of_income'      => $this->faker->randomElement(['salary', 'business', 'investments']),
            'annual_income_range'   => $this->faker->randomElement(['<50k', '50k-100k', '100k-200k', '200k+']),
            'net_worth'             => $this->faker->randomFloat(2, 1000, 1000000),
            'investment_experience' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']),
            'risk_tolerance'        => $this->faker->randomElement(['low', 'medium', 'high']),
            'investment_objectives' => $this->faker->sentence,
            'terms_agreed'          => true,
            'privacy_policy_consented' => true,
            'risk_disclosure_agreed'=> true,
            'tax_form'              => null,
            'password'              => Hash::make('password'),
            'is_admin'              => false,
        ];
    }

    /**
     * Custom state for admin users.
     * Overrides the password to "Admin" and sets is_admin to true.
     */
    public function adminUser()
    {
        return $this->state(function (array $attributes) {
            return [
                'password' => Hash::make('Admin'),
                'is_admin' => true,
            ];
        });
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Seed only the two admin users with fixed name, email, and password "Admin"
        User::factory()->adminUser()->create([
            'first_name' => 'Nathanial',
            'last_name'  => 'NoeCapital',
            'email'      => 'nathanial@noecapital.nl',
        ]);

        User::factory()->adminUser()->create([
            'first_name' => 'Bkonadu',
            'last_name'  => 'NoeCapital',
            'email'      => 'Bkonadu@noecapital.nl',
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles if they don't already exist
        Role::firstOrCreate(['name' => 'client']);
        Role::firstOrCreate(['name' => 'admin']);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::beginTransaction();

        try {
            User::factory()->create([
                'first_name' => 'Nathanial',
                'last_name'  => 'NoeCapital',
                'email'      => 'nathanial@noecapital.nl',
                'password'   => Hash::make('Admin'),
                'is_admin'   => true,
            ]);

            User::factory()->create([
                'first_name' => 'Bkonadu',
                'last_name'  => 'NoeCapital',
                'email'      => 'Bkonadu@noecapital.nl',
                'password'   => Hash::make('Admin'),
                'is_admin'   => true,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dump($e->getMessage());
        }
    }
}

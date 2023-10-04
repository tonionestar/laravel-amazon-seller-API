<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'full_name'              => 'Brian Gregg',
            'email'             => 'admin@salepower.io',
            'address'             => '16657 Orange Way Fontana California 92335',
            'phone_number'             => '123 456 7890',
            'position'                  => '1',
            'role'                  => 'Admin',
            'password'          => Hash::make('admin'),
            'email_verified_at' => now(),
        ]);
    }
}

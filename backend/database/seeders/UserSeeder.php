<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Seed a verified test user (meets strong password rules)
        DB::table('users')->updateOrInsert(
            ['email' => 'test.user@pinoy-paypal.local'],
            [
                'full_name'          => 'Test User',
                'mobile_number'      => '09171234567',
                'password'           => Hash::make('P@ssw0rd123A'), // >=8, with uppercase + number
                'is_verified'        => true,
                'two_factor_secret'  => null,
                'two_factor_enabled' => false,
                'last_login_at'      => null,
                'last_login_ip'      => null,
                'email_verified_at'  => now(),
                'created_at'         => now(),
                'updated_at'         => now(),
            ]
        );
    }
}

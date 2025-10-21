<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutMiddleware(VerifyCsrfToken::class);
});

it('throttles excessive login attempts', function () {
    $email = 'thr+'.uniqid().'@pinoy-paypal.local';
    DB::table('users')->insert([
        'email' => $email,
        'password' => Hash::make('StrongPass1'),
        'full_name' => 'Throttle User',
        'is_verified' => false,
        'two_factor_enabled' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // 5 bad attempts -> 422, 6th -> 429
    for ($i = 1; $i <= 5; $i++) {
        $this->postJson('/api/login', ['email' => $email, 'password' => 'WrongPass1'])
            ->assertStatus(422);
    }

    $this->postJson('/api/login', ['email' => $email, 'password' => 'WrongPass1'])
        ->assertStatus(429);
});
<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutMiddleware(VerifyCsrfToken::class);
});

it('requires auth for /api/user when not logged in', function () {
    $this->getJson('/api/user')->assertUnauthorized();
});

it('logs in, reads /api/user, then logs out', function () {
    // insert a compatible user (table requires full_name, etc.)
    $email = 'login+'.uniqid().'@pinoy-paypal.local';
    DB::table('users')->insert([
        'email' => $email,
        'password' => Hash::make('Passw0rd!'),
        'full_name' => 'Login User',
        'is_verified' => false,
        'two_factor_enabled' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->postJson('/api/login', [
        'email' => $email,
        'password' => 'Passw0rd!',
    ])->assertNoContent();

    $this->getJson('/api/user')
        ->assertOk()
        ->assertJsonPath('email', $email);

    $this->postJson('/api/logout')->assertNoContent();

    $this->getJson('/api/user')->assertUnauthorized();
});
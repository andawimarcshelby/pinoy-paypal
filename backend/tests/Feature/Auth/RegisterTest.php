<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutMiddleware(VerifyCsrfToken::class);
});

it('registers a user with a strong password', function () {
    $email = 'test+'.uniqid().'@pinoy-paypal.local';

    $res = $this->postJson('/api/register', [
        'full_name' => 'Alice Test',
        'email' => $email,
        'mobile_number' => '09171234568',
        'password' => 'StrongPass1',
        'password_confirmation' => 'StrongPass1',
    ]);

    $res->assertCreated()
        ->assertJsonPath('message', 'Registered successfully.')
        ->assertJsonStructure(['user' => ['id','email','full_name']]);

    $this->assertDatabaseHas('users', ['email' => $email]);
});

it('rejects weak passwords', function () {
    $email = 'weak+'.uniqid().'@pinoy-paypal.local';

    $res = $this->postJson('/api/register', [
        'full_name' => 'Bob Weak',
        'email' => $email,
        'mobile_number' => '09170001111',
        'password' => 'weakpass1', // no uppercase
        'password_confirmation' => 'weakpass1',
    ]);

    $res->assertStatus(422)->assertJsonValidationErrors(['password']);
});
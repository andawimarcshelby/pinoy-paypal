<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Mass-assignable fields per project spec.
     */
    protected $fillable = [
        'full_name',
        'email',
        'mobile_number',
        'password',
        'is_verified',
        'two_factor_secret',
        'two_factor_enabled',
        'last_login_at',
        'last_login_ip',
        'email_verified_at',
    ];

    /**
     * Hidden fields for arrays/JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    /**
     * Attribute casting.
     * 'password' => 'hashed' ensures bcrypt hashing automatically.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at'     => 'datetime',
        'is_verified'       => 'boolean',
        'two_factor_enabled'=> 'boolean',
        'password'          => 'hashed',
    ];
}

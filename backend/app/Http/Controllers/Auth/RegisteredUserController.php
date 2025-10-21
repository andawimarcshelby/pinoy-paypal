<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Register a new user (API).
     * Requirements per spec:
     * - full_name (required)
     * - email (unique)
     * - mobile_number (optional, numeric pattern)
     * - password (min 8, ≥1 uppercase, ≥1 number, confirmed)
     * - bcrypt hashing (handled by User::$casts['password' => 'hashed'])
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'mobile_number' => ['nullable', 'string', 'max:32', 'regex:/^\+?[0-9]{7,15}$/'],
            'password' => [
                'required',
                'confirmed',
                // min 8, at least one letter, at least one number
                Password::min(8)->letters()->numbers(),
                // ensure at least one UPPERCASE letter (separate regex rule)
                'regex:/[A-Z]/',
            ],
        ]);

        // Create user (password auto-bcrypted via model cast)
        $user = User::create([
            'full_name'          => $validated['full_name'],
            'email'              => $validated['email'],
            'mobile_number'      => $validated['mobile_number'] ?? null,
            'password'           => $validated['password'],
            'is_verified'        => false,
            'two_factor_enabled' => false,
        ]);

        event(new Registered($user));

        // Auto-login this user for SPA convenience (Sanctum session)
        Auth::login($user);

        return response()->json([
            'message' => 'Registered successfully.',
            'user' => [
                'id'                => $user->id,
                'full_name'         => $user->full_name,
                'email'             => $user->email,
                'mobile_number'     => $user->mobile_number,
                'is_verified'       => $user->is_verified,
                'two_factor_enabled'=> $user->two_factor_enabled,
                'created_at'        => $user->created_at,
            ],
        ], 201);
    }
}

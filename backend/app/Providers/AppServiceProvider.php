<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Named limiter used by routes: 'throttle:login'
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->input('email', '');
            // 5 attempts per minute keyed by email+IP
            return [
                Limit::perMinute(5)->by($email.'|'.$request->ip()),
            ];
        });
    }
}

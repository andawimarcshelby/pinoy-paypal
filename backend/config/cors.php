<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | We allow the Vite dev server at http://localhost:3000 to make cookie-
    | based requests (withCredentials) to our Laravel API.
    |
    */

    // Apply CORS to API routes and Sanctum's CSRF cookie endpoint
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Allow all HTTP methods for simplicity in dev
    'allowed_methods' => ['*'],

    // Allowed origins: read from .env (CORS_ALLOWED_ORIGINS), default to :3000
    // Example .env: CORS_ALLOWED_ORIGINS=http://localhost:3000
    'allowed_origins' => explode(',', env('CORS_ALLOWED_ORIGINS', 'http://localhost:3000')),

    // No origin patterns needed
    'allowed_origins_patterns' => [],

    // All headers are fine for dev (Axios, etc.)
    'allowed_headers' => ['*'],

    // No custom exposed headers for now
    'exposed_headers' => [],

    // Cache time for preflight. 0 = no caching during dev
    'max_age' => 0,

    // IMPORTANT: allow cookies for SPA auth (XSRF-TOKEN + laravel_session)
    'supports_credentials' => true,
];

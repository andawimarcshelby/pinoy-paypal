<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_logs', function (Blueprint $table) {
            $table->id();

            // Link to users; cascade delete logs if the user is removed
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // IPv4 or IPv6
            $table->string('ip_address', 45)->nullable();

            // Browser/OS agent string
            $table->text('user_agent')->nullable();

            $table->timestamps();

            // Helpful index for retrieving latest logs per user
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_logs');
    }
};

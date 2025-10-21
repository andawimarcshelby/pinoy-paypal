<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Spec fields
            $table->string('full_name')->after('id');
            $table->string('mobile_number', 32)->nullable()->after('email');
            $table->boolean('is_verified')->default(false)->after('password');
            $table->text('two_factor_secret')->nullable()->after('is_verified');
            $table->boolean('two_factor_enabled')->default(false)->after('two_factor_secret');
            $table->timestamp('last_login_at')->nullable()->after('remember_token');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');

            // Remove legacy Laravel "name" column since spec uses full_name
            $table->dropColumn('name');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Recreate legacy column
            $table->string('name')->nullable()->after('id');

            // Drop spec fields
            $table->dropColumn([
                'full_name',
                'mobile_number',
                'is_verified',
                'two_factor_secret',
                'two_factor_enabled',
                'last_login_at',
                'last_login_ip',
            ]);
        });
    }
};

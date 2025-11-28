<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // add a unique index to `phone` if it doesn't already exist
        if (!Schema::hasColumn('users', 'phone')) {
            // nothing to do
            return;
        }

        try {
            // For MySQL, check existing indexes via SHOW INDEX
            $existing = DB::select("SHOW INDEX FROM `users` WHERE Column_name = ? AND Non_unique = 0", ['phone']);
            if (empty($existing)) {
                Schema::table('users', function (Blueprint $table) {
                    $table->unique('phone', 'users_phone_unique');
                });
            }
        } catch (\Throwable $e) {
            // If anything fails (different DB engine or missing permissions), skip adding and log silently.
            // Avoid throwing during migration to prevent BadMethodCall when doctrine/dbal missing.
        }
    }

    public function down(): void
    {
        try {
            $existing = DB::select("SHOW INDEX FROM `users` WHERE Column_name = ? AND Non_unique = 0", ['phone']);
            // If there is still a unique index with this name, drop it. We'll attempt to drop by name to be safe.
            if (!empty($existing)) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropUnique('users_phone_unique');
                });
            }
        } catch (\Throwable $e) {
            // ignore
        }
    }
};

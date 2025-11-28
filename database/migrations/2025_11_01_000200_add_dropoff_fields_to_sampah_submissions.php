<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sampah_submissions', function (Blueprint $table) {
            $table->string('dropoff_location')->nullable()->after('metode');
            $table->timestamp('dropoff_deadline')->nullable()->after('dropoff_location');
            $table->timestamp('dropoff_confirmed_at')->nullable()->after('dropoff_deadline');
        });
    }

    public function down(): void
    {
        Schema::table('sampah_submissions', function (Blueprint $table) {
            $table->dropColumn(['dropoff_location','dropoff_deadline','dropoff_confirmed_at']);
        });
    }
};

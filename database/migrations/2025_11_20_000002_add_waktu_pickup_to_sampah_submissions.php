<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sampah_submissions', function (Blueprint $table) {
            $table->string('waktu_pickup')->nullable()->after('tanggal_pickup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sampah_submissions', function (Blueprint $table) {
            $table->dropColumn('waktu_pickup');
        });
    }
};

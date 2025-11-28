<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sampah_submissions', function (Blueprint $table) {
            $table->text('reject_reason')->nullable()->after('points_awarded');
        });
    }

    public function down()
    {
        Schema::table('sampah_submissions', function (Blueprint $table) {
            $table->dropColumn('reject_reason');
        });
    }
};

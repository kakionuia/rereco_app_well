<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sampah_submissions', function (Blueprint $table) {
            $table->text('admin_message')->nullable()->after('reject_reason');
        });
    }

    public function down()
    {
        Schema::table('sampah_submissions', function (Blueprint $table) {
            $table->dropColumn('admin_message');
        });
    }
};

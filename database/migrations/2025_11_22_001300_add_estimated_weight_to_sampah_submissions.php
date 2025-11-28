<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sampah_submissions', function (Blueprint $table) {
            $table->decimal('estimated_weight', 8, 2)->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sampah_submissions', function (Blueprint $table) {
            if (Schema::hasColumn('sampah_submissions', 'estimated_weight')) {
                $table->dropColumn('estimated_weight');
            }
        });
    }
};

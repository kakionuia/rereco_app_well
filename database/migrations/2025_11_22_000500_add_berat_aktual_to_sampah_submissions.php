<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sampah_submissions', function (Blueprint $table) {
            $table->decimal('berat_aktual', 8, 2)->nullable()->after('ongkir');
        });
    }

    public function down()
    {
        Schema::table('sampah_submissions', function (Blueprint $table) {
            $table->dropColumn('berat_aktual');
        });
    }
};

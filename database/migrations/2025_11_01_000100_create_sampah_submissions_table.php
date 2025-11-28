<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sampah_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('jenis')->nullable();
            $table->string('foto_path')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('metode')->nullable(); // pickup or dropoff

            // pickup specific
            $table->string('nama_pickup')->nullable();
            $table->text('alamat_pickup')->nullable();
            $table->date('tanggal_pickup')->nullable();
            $table->string('ekspedisi')->nullable();
            $table->string('ongkir')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sampah_submissions');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('tier')->index(); // bronze, silver, gold, diamond, obsidian
            $table->string('code')->unique();
            $table->enum('discount_type', ['percent','fixed'])->default('percent');
            $table->integer('discount_value')->default(10); // percent or fixed amount (in IDR)
            $table->integer('stock')->default(0); // how many times the voucher can be claimed/used in total
            $table->timestamps();
        });

        // seed default vouchers
        DB::table('vouchers')->insert([
            ['tier' => 'bronze', 'code' => 'BRONZE10', 'discount_type' => 'percent', 'discount_value' => 10, 'stock' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['tier' => 'silver', 'code' => 'SILVER20', 'discount_type' => 'percent', 'discount_value' => 20, 'stock' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['tier' => 'gold', 'code' => 'GOLD30', 'discount_type' => 'percent', 'discount_value' => 30, 'stock' => 20, 'created_at' => now(), 'updated_at' => now()],
            ['tier' => 'diamond', 'code' => 'DIAMOND40', 'discount_type' => 'percent', 'discount_value' => 40, 'stock' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['tier' => 'obsidian', 'code' => 'OBSIDIAN50', 'discount_type' => 'percent', 'discount_value' => 50, 'stock' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
};

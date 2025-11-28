<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DB::table('categories')->where('slug', 'rewards')->exists()) {
            DB::table('categories')->insert([
                'name' => 'Rewards',
                'slug' => 'rewards',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->where('slug', 'rewards')->delete();
    }
};

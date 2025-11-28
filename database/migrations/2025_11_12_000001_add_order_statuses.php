<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Add new status values: 'canceled' and 'on_the_way' alongside existing 'pending', 'confirmed', 'delivered', 'rejected'
        // Using raw SQL to update the ENUM if needed, or simply allow the column to accept new values
        // For MySQL ENUM, we need to modify the column
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY status ENUM('pending', 'confirmed', 'on_the_way', 'delivered', 'canceled', 'rejected') DEFAULT 'pending'");
        }
    }

    public function down()
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY status ENUM('pending', 'confirmed', 'delivered', 'rejected') DEFAULT 'pending'");
        }
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddComplainedRefundedToOrdersStatusEnum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add 'complained' and 'refunded' to orders.status enum
        DB::statement("ALTER TABLE `orders` MODIFY `status` ENUM('pending','confirmed','on_the_way','delivered','canceled','rejected','complained','refunded') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert to previous enum values. Ensure no rows contain the removed values before running rollback.
        DB::statement("ALTER TABLE `orders` MODIFY `status` ENUM('pending','confirmed','on_the_way','delivered','canceled','rejected') NOT NULL DEFAULT 'pending'");
    }
}

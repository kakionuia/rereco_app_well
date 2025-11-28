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
        $rewards = DB::table('categories')->where('slug', 'rewards')->first();
        if (! $rewards) {
            return;
        }

        // Update products that mistakenly used 'rewards' as category_id (string)
        DB::table('products')->where('category_id', 'rewards')->update(['category_id' => $rewards->id]);

        // Update products with category_id that doesn't exist in categories
        $validIds = DB::table('categories')->pluck('id')->toArray();
        DB::table('products')->whereNotIn('category_id', $validIds)->update(['category_id' => $rewards->id]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No-op: we won't try to restore previous mismatched IDs
    }
};

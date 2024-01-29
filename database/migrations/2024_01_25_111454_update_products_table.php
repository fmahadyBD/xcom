<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    // for update the products table.
    Schema::table('products',function($table){
        $table->string('product_weight')->after('product_name')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('products',function($table){
        //     $table->$table->dropColumn('product_weight');
        // });
    }
};

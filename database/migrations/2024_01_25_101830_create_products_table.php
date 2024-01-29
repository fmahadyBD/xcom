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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('product_name')->nullable();
            $table->string('product_code')->nullable();
            $table->string('product_color')->nullable();
            $table->string('family_color')->nullable();
            $table->string('group_code')->nullable();
            $table->float('product_price')->nullable();
            $table->float('product_discount')->nullable();
            $table->string('discount_type')->nullable();
            $table->text('description')->nullable();
            $table->text('wish_care')->nullable();
            $table->text('keywords')->nullable();
            $table->string('product_video')->nullable();


            $table->integer('category_id')->nullable();
            $table->integer('brand_id')->nullable();

            $table->float('final_price')->nullable();

            $table->string('fabric')->nullable();
            $table->string('pattern')->nullable();
            $table->string('sleeve')->nullable();
            $table->string('fit')->nullable();
            $table->string('ocassion')->nullable();

            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->enum('id_featured',['No','yes']);
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

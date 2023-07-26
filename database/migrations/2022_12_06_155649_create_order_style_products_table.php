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
        Schema::create('order_style_products', function (Blueprint $table) {
            $table->id();
            $table->integer('original_price');
            $table->integer('total_value');
            $table->integer('buying_quantity');
            $table->boolean('is_delivery_free')->default(0);
            $table->char('assign_delivery_free')->default('pending');
            $table->foreignId('flash_sale_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('discount_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('sub_product_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('floor_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_style_products');
    }
};

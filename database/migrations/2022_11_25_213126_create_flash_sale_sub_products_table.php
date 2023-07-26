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
        Schema::create('flash_sale_sub_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flash_sale_id')->constrained();
            $table->foreignId('sub_product_id')->constrained();
            $table->integer('discount_value');
            $table->integer('quantity')->nullable();
            $table->integer('max_buying_count')->nullable();
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
        Schema::dropIfExists('flash_sale_sub_products');
    }
};

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->char('order_id')->unique();
            $table->dateTime('date');
            $table->integer('total_original_price');
            $table->integer('total_discount_value');
            $table->integer('total_value');
            $table->integer('total_quantity');
            $table->boolean('is_delivery_free')->default(0);
            $table->integer('tax');
            $table->integer('delivery_fee');
            $table->char('status');
            $table->foreignId('payment_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('delivery_man_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('address_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
};

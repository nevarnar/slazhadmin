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
        Schema::create('sale_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_product_id');
            $table->integer('qty');
            $table->integer('amount')->default(0);
            $table->foreignId('reason_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('floor_id')->nullable();
            $table->unsignedBigInteger('delivery_man_id')->nullable();
            $table->integer('orderitemable_id');
            $table->char('orderitemable_type');
            $table->char('status')->default('received');
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
        Schema::dropIfExists('sale_returns');
    }
};

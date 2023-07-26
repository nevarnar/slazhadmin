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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->char('transfer_id')->unique();
            $table->unsignedBigInteger('from_inventory_id');
            $table->unsignedBigInteger('to_inventory_id');
            $table->dateTime('send_date')->default(now());
            $table->dateTime('arrive_date');
            $table->char('status')->default('pending');  #pending , accept ,delete
            $table->foreign('from_inventory_id')->references('id')->on('inventories')->onDelete('cascade');
            $table->foreign('to_inventory_id')->references('id')->on('inventories')->onDelete('cascade');
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
        Schema::dropIfExists('transfers');
    }
};

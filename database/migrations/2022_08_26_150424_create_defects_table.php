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
        Schema::create('defects', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->text('remark');
            $table->boolean('status')->default('0');   
            $table->foreignId('floor_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_product_id')->constrained()->onDelete('cascade');
            // $table->foreignId('inventory_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('defects');
    }
};

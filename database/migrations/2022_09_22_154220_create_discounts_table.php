<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time')->nullable();
            $table->boolean('is_flash_sale')->default(false);
            $table->integer('quantity')->nullable();
            $table->integer('discountable_id');
            $table->char('discountable_type');
            $table->integer('discount_value')->nullable();
            $table->integer('min_buying_amount')->nullable();
            $table->foreignId('discount_type_id')->constrained()->onDelete('cascade');
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
         Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('discounts');
       

    }
};
 
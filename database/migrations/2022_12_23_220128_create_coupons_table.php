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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->char('code',45);
            $table->date('start_date');
            $table->date('end_date');
            $table->char('photo',45);
            $table->integer('count')->default(0);
            $table->integer('discount_value')
            ->nullable();
            $table->integer('min_buying_amount')->default(0);
            $table->foreignId('coupon_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('coupon_discount_type_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('coupons');
    }
};

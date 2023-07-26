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
        Schema::create('coupon_limitation', function (Blueprint $table) {
            $table->foreignId('coupon_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('limitable_id');
            $table->char('limitable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_limitation');
    }
};

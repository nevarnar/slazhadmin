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
        Schema::create('min_buying_condition', function (Blueprint $table) {
            $table->foreignId('coupon_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('buyable_id');
            $table->char('buyable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('min_buying_condition');
    }
};

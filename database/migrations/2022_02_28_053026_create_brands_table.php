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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('sku_name', 45)->unique();
            $table->string('logo', 100)->nullable();
            $table->string('photo', 100)->nullable();
            $table->boolean('is_available')->default(true); 
            $table->boolean('is_feature')->default(0); #men_feature
            $table->boolean('is_women_feature')->default(0);
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('brands');
    }
};

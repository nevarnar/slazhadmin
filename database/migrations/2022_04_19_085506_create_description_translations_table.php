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
        Schema::create('description_translations', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('language_code',45);
            $table->unsignedBigInteger('description_translationable_id');
            $table->string('description_translationable_type', 25);
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
        Schema::dropIfExists('description_translations');
    }
};

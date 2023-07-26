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
        Schema::create('name_translations', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->unsignedBigInteger('name_translationable_id');
            $table->string('name_translationable_type', 25);
            $table->string('language_code', 15);
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
        Schema::dropIfExists('name_translations');
    }
};

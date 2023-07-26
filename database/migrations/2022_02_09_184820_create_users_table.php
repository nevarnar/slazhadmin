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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->char('email', 100)->nullable()->unique();
            $table->char('phone_number', 50)->nullable()->unique();
            $table->char('new_phone_number', 50)->nullable();
            $table->char('name', 200)->nullable();
            $table->char('password', 200)->nullable();
            $table->char('image_name')->nullable();
            $table->char('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('height')->nullable();
            $table->integer('chest')->nullable();
            $table->integer('waist')->nullable();
            $table->integer('shoulder')->nullable();
            $table->integer('hip')->nullable();
            $table->text('avatar')->nullable();
            $table->integer('verify_code')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_archive')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};

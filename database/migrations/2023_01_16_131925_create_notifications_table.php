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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_read')->default(0);
            // $table->integer('notify')->unsigned();
            $table->integer('notificationable_id');
            $table->char('notificationable_type');
            $table->dateTime('read_at')->nullable();
            $table->foreignId('notify_id')->constrained()->onDelete('cascade');
            // $table->foreign('notify_id')->references('id')->on('notifies')->onDelete('cascade');
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
        Schema::dropIfExists('notifications');
    }
};

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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->char('user_name',45)->unique();
            $table->char('full_name',45);
            $table->char('email');
            $table->char('phone_number',45)->unique();
            $table->text('address');
            $table->char('password');
            $table->foreignId('admin_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('inventory_id')->nullable()->constrained()->onDelete('cascade');
            $table->char('facebook_id')->nullable();
            $table->char('google_id')->nullable();
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
        Schema::dropIfExists('admins');
    }
};

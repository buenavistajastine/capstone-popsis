<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_dish_keys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->foreign('booking_id')->references('id')->on('bookings');

            $table->unsignedBigInteger('dish_id');
            $table->foreign('dish_id')->references('id')->on('dishes');

            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses');

            $table->dateTime('dt_accepted')->nullable();
            $table->dateTime('dt_completed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_dish_keys');
    }
};

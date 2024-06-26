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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_no')->nullable();
            $table->unsignedBigInteger('customer_id')->constrained()->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->unsignedBigInteger('package_id');
            $table->foreign('package_id')->references('id')->on('packages');

            $table->unsignedBigInteger('venue_id')->nullable();
            $table->foreign('venue_id')->references('id')->on('venues');

            $table->string('event_name')->nullable();

            // $table->string('venue_address');
            $table->string('no_pax');
            $table->date('date_event')->nullable();
            $table->time('call_time')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->dateTime('dt_booked');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses');

            $table->longText('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

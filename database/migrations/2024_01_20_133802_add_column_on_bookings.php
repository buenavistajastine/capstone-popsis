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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('city')->nullable()->after('venue_id');
            $table->string('barangay')->nullable()->after('city');
            $table->string('specific_address')->nullable()->after('venue_address');
            $table->string('landmark')->nullable()->after('specific_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->dropColumn('barangay');
            $table->dropColumn('specific_address');
            $table->dropColumn('landmark');
        });
    }
};

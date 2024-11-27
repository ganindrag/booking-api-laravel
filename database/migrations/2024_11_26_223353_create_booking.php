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
        Schema::create('bookingperiods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('room_id')->constrained();
            $table->date('date');
            $table->foreignId('bookingperiod_id')->constrained();
            $table->text('memo')->nullable();
            $table->timestamps();
        });

        Schema::create('attendants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('booking_id')->constrained();
            $table->unique(['user_id', 'booking_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookingperiods');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('attendants');
    }
};

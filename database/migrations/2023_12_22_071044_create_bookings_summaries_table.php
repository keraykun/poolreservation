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
        Schema::create('bookings_summaries', function (Blueprint $table) {
            $table->id();
           // $table->foreignId('booking_id')->constrained('bookings')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('barcode');
            $table->float('room_price',8,2)->nullable();
            $table->float('schedule_price',8,2)->nullable();
            $table->float('food_price',8,2)->nullable();
            $table->float('partial',8,2)->nullable();
            $table->float('total',8,2)->nullable();
            $table->boolean('partial_status')->default(0);
            $table->date('date_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings_summaries');
    }
};

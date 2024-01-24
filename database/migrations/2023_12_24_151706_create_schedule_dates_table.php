<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_dates', function (Blueprint $table) {
            $table->id();
            $table->date('appointment_date');
            $table->unsignedBigInteger('time_slots_id');
            $table->boolean('booked')->default(false);
            $table->timestamps();
            $table->foreign('time_slots_id')->references('id')->on('time_slots');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('schedule_dates');
    }
};

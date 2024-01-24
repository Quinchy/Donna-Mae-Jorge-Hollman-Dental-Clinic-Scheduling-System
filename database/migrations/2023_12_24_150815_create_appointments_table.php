<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('schedule_id');
            $table->string('status')->default('Processing');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('schedule_id')->references('id')->on('schedule_dates');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};

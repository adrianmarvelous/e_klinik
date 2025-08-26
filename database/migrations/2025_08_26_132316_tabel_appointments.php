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
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->unsignedBigInteger('doctor_id'); // FK to users.id
            $table->dateTime('datetime');
            $table->string('status')->default('pending'); // pending, confirmed, canceled
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }

};

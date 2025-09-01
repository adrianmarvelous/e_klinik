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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            // automatically references `id` on `users`

            $table->string('name');
            $table->string('specialization')->nullable(); // e.g. cardiologist, dentist
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->text('bio')->nullable(); // short profile / description
            $table->string('photo')->nullable(); // store path to profile picture
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};

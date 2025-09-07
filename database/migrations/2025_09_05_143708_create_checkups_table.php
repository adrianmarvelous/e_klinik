<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id');
            $table->unsignedBigInteger('poli_id'); // tambahkan poli_id
            $table->text('diagnosis')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('appointment_id')
                  ->references('id')->on('appointments')
                  ->onDelete('cascade');

            $table->foreign('poli_id')
                  ->references('id')->on('polis')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkups');
    }
};

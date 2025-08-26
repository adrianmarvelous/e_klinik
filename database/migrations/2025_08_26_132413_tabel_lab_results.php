<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('record_id')->constrained('medical_records')->onDelete('cascade');
            $table->string('type'); // darah, urine, etc.
            $table->text('result_text')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_results');
    }

};

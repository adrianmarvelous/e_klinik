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
    Schema::table('medical_history', function (Blueprint $table) {
        $table->text('main_complaint')->nullable();
        $table->text('additional_complaint')->nullable();
        $table->string('illness_duration')->nullable();
        $table->boolean('smoking')->nullable();
        $table->boolean('alcohol_consumption')->nullable();
        $table->boolean('low_fruit_veggie_intake')->nullable();
    });
}

public function down(): void
{
    Schema::table('medical_history', function (Blueprint $table) {
        $table->dropColumn([
            'main_complaint',
            'additional_complaint',
            'illness_duration',
            'smoking',
            'alcohol_consumption',
            'low_fruit_veggie_intake',
        ]);
    });
}

};

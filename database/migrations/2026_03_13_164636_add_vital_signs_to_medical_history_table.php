<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medical_history', function (Blueprint $table) {
            $table->string('blood_pressure')->nullable()->after('comorbidity');
            $table->float('height')->nullable()->after('blood_pressure');
            $table->float('weight')->nullable()->after('height');
            $table->integer('heart_rate')->nullable()->after('weight');
        });
    }

    public function down(): void
    {
        Schema::table('medical_history', function (Blueprint $table) {
            $table->dropColumn([
                'blood_pressure',
                'height',
                'weight',
                'heart_rate'
            ]);
        });
    }
};
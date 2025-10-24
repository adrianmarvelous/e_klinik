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
            $table->tinyInteger('wa_patient')->default(0)->after('low_fruit_veggie_intake')->comment('0 = no, 1 = yes');
            $table->tinyInteger('wa_doctor')->default(0)->after('wa_patient')->comment('0 = no, 1 = yes');
        });
    }

    public function down(): void
    {
        Schema::table('medical_history', function (Blueprint $table) {
            $table->dropColumn(['wa_patient', 'wa_doctor']);
        });
    }
};

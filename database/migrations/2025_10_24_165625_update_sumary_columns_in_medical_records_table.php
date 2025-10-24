<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::table('medical_records', function (Blueprint $table) {
            // Rename existing column 'summary' → 'patient_summary'
            $table->renameColumn('summary', 'patient_summary');

            // Add new column for doctor's summary
            $table->text('doctor_summary')->nullable()->after('patient_summary');
        });
    }

    public function down()
    {
        Schema::table('medical_records', function (Blueprint $table) {
            // Rollback changes: remove doctor_summary and rename column back
            $table->dropColumn('doctor_summary');
            $table->renameColumn('patient_summary', 'summary');
        });
    }
};

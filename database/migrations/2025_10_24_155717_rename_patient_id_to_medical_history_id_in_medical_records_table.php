<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('medical_records', function (Blueprint $table) {
            // 1. Drop old foreign key if exists
            $table->dropForeign(['patient_id']);

            // 2. Rename column
            $table->renameColumn('patient_id', 'medical_history_id');
        });

        Schema::table('medical_records', function (Blueprint $table) {
            // 3. Add new foreign key reference to medical_history table
            $table->foreign('medical_history_id')
                ->references('id')
                ->on('medical_history')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('medical_records', function (Blueprint $table) {
            // Reverse process if you rollback
            $table->dropForeign(['medical_history_id']);
            $table->renameColumn('medical_history_id', 'patient_id');
            $table->foreign('patient_id')
                ->references('id')
                ->on('patients')
                ->onDelete('cascade');
        });
    }
};

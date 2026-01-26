<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('medical_history', function (Blueprint $table) {
            $table->unsignedBigInteger('doctor_id')
                  ->nullable()
                  ->after('patient_id');
        });
    }

    public function down(): void
    {
        Schema::table('medical_history', function (Blueprint $table) {
            $table->dropColumn('doctor_id');
        });
    }
};

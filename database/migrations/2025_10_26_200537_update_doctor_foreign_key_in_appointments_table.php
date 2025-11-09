<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Drop old foreign key constraint to users
            $table->dropForeign(['doctor_id']);

            // Add new foreign key referencing doctors.id
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'doctor_id')) {
                try {
                    $table->dropForeign(['doctor_id']);
                } catch (\Exception $e) {
                    // Ignore if foreign key doesn't exist
                }
            }
        });
    }
};

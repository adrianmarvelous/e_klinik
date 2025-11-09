<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Drop old foreign key on doctor_id if exists
        $fkDoctor = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = 'appointments' 
              AND COLUMN_NAME = 'doctor_id' 
              AND CONSTRAINT_SCHEMA = DATABASE()
              AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if (!empty($fkDoctor)) {
            $fk = $fkDoctor[0]->CONSTRAINT_NAME;
            DB::statement("ALTER TABLE appointments DROP FOREIGN KEY `$fk`");
        }

        // Step 2: Drop doctor_id column if exists
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'doctor_id')) {
                $table->dropColumn('doctor_id');
            }
        });

        // Step 3: Add poli_id column if not exists
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'poli_id')) {
                $table->unsignedBigInteger('poli_id')->nullable()->after('patient_id');
            }
        });

        // Step 4: Ensure there's a default record in polis
        DB::statement('INSERT IGNORE INTO polis (id, name) VALUES (1, "Default Poli")');

        // Step 5: Fix invalid or null poli_id values before FK
        DB::statement('UPDATE appointments SET poli_id = 1 WHERE poli_id IS NULL OR poli_id NOT IN (SELECT id FROM polis)');

        // Step 6: Drop existing FK on poli_id if exists (safety)
        $fkPoli = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = 'appointments' 
              AND COLUMN_NAME = 'poli_id' 
              AND CONSTRAINT_SCHEMA = DATABASE()
              AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if (!empty($fkPoli)) {
            $fk = $fkPoli[0]->CONSTRAINT_NAME;
            DB::statement("ALTER TABLE appointments DROP FOREIGN KEY `$fk`");
        }

        // Step 7: Add new foreign key for poli_id
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign('poli_id')
                  ->references('id')
                  ->on('polis')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Step 1: Drop foreign key on poli_id if exists
        $fkPoli = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = 'appointments' 
              AND COLUMN_NAME = 'poli_id' 
              AND CONSTRAINT_SCHEMA = DATABASE()
              AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if (!empty($fkPoli)) {
            $fk = $fkPoli[0]->CONSTRAINT_NAME;
            DB::statement("ALTER TABLE appointments DROP FOREIGN KEY `$fk`");
        }

        // Step 2: Drop poli_id column if exists
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'poli_id')) {
                $table->dropColumn('poli_id');
            }
        });

        // Step 3: Recreate doctor_id column and FK
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'doctor_id')) {
                $table->unsignedBigInteger('doctor_id')->nullable();
                $table->foreign('doctor_id')
                      ->references('id')
                      ->on('users')
                      ->onDelete('cascade');
            }
        });
    }
};

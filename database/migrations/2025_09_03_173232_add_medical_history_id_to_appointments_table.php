<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Add the new column (nullable if optional)
            $table->unsignedBigInteger('medical_history_id')->nullable()->after('id');

            // Add foreign key constraint (if you have medical_histories table)
            $table->foreign('medical_history_id')
                  ->references('id')
                  ->on('medical_history')
                  ->onDelete('set null'); // or cascade
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['medical_history_id']);
            $table->dropColumn('medical_history_id');
        });
    }
};

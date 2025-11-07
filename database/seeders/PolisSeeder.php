<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ✅ ADD THIS LINE
use Illuminate\Support\Carbon;     // optional if you use Carbon

class PolisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('polis')->insert([
            [
                'name' => 'Fisioterapi',
                'description' => 'Pelayanan fisioterapi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Okupasi',
                'description' => 'Pelayanan terapi okupasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hydroterapi',
                'description' => 'Pelayanan terapi hidroterapi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Akupuntur',
                'description' => 'Pelayanan terapi akupuntur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

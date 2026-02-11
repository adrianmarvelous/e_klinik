<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ✅ ADD THIS LINE
use Illuminate\Support\Carbon;     // optional if you use Carbon

class Doctor_Physio extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('doctors')->insert([
            [
                'name' => 'Juliana Tri Utami',
                'user_id' => '8',
                'specialization' => 'terapis fisioterapi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '⁠Lalu Wahidin',
                'user_id' => '8',
                'specialization' => 'terapis fisioterapi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Achmad Bestari',
                'user_id' => '8',
                'specialization' => 'terapis wicara',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'dr. Moerdjajati, Sp.KFR',
                'user_id' => '8',
                'specialization' => 'dokter rehab',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'dr. Agustinus sujatmiko, Sp. S',
                'user_id' => '8',
                'specialization' => 'dokter syaraf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'dr. Alvin Harja, Mars, Sp. Ak',
                'user_id' => '8',
                'specialization' => 'dokter akupuntur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles safely
        $roles = ['admin', 'doctor', 'patient', 'fisioterapi'];

        foreach ($roles as $r) {
            Role::firstOrCreate([
                'name' => $r,
                'guard_name' => 'web',
            ]);
        }

        // Create users safely
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin', 'password' => Hash::make('password')]
        );

        $doctor = User::firstOrCreate(
            ['email' => 'dokter@gmail.com'],
            ['name' => 'Dokter', 'password' => Hash::make('password')]
        );

        $fisioterapi = User::firstOrCreate(
            ['email' => 'fisioterapi@gmail.com'],
            ['name' => 'Fisioterapi', 'password' => Hash::make('password')]
        );

        $patient = User::firstOrCreate(
            ['email' => 'pasien@gmail.com'],
            ['name' => 'Pasien', 'password' => Hash::make('password')]
        );

        // Assign roles (safe)
        $admin->syncRoles('admin');
        $doctor->syncRoles('doctor');
        $fisioterapi->syncRoles('fisioterapi');
        $patient->syncRoles('patient');

        // Call other seeders
        $this->call(PolisSeeder::class);
    }
}

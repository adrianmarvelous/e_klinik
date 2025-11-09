<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Roles;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Example: create 10 random users
        // User::factory(10)->create();

        // Create specific users manually
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // optional, just for login
        ]);

        User::factory()->create([
            'name' => 'Dr. James Cooper',
            'email' => 'katim@gmail.com',
            'password' => '$2y$12$UTeV9nt8qboNqDxn1oFUMOhWDWsJ6tQjvDfm8NKZeDQcWiLGj4um6', // already hashed
        ]);

        User::factory()->create([
            'name' => 'Adrian Marvel Ugrasena',
            'email' => 'adrianmarvelugr@gmail.com',
            'password' => '$2y$12$5moGpwog4AW3Ftsjs52oeuDwbJ8uXY2b73WsXW0aFBJNHiE6TsD/6', // already hashed
        ]);

        User::factory()->create([
            'name' => 'Nancy Martha',
            'email' => 'nancymartha89@gmail.com',
            'password' => '$2y$12$MypqKtJfXJJSJqBnBQ0tgOdAng2.YNKVjHDZrloAs2wtAqfALwHEG', // already hashed
        ]);

        Roles::factory()->create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        Roles::factory()->create([
            'name' => 'doctor',
            'guard_name' => 'web',
        ]);

        Roles::factory()->create([
            'name' => 'patient',
            'guard_name' => 'web',
        ]);

        // Call another seeder
        $this->call(PolisSeeder::class);
    }
}

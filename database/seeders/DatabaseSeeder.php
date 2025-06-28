<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder separado
        $this->call(AdminUserSeeder::class);

        // Asegurar usuario de prueba
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('test1234'),
                'rol' => 'usuario'
            ]
        );

        // Asegurar usuario admin
        User::updateOrCreate(
            ['email' => 'admin@tagabi.com'],
            [
                'name' => 'Tania Admin',
                'password' => Hash::make('12345678'),
                'rol' => 'admin'
            ]
        );
    }
}

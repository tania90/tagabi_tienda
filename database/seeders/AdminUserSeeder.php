<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@tagabi.com'],
            [
                'name' => 'Tania Admin',
                'email' => 'admin@tagabi.com',
                'password' => Hash::make('admin123'), // Cambiá luego por seguridad
                'rol' => 'admin' // si tenés un campo "rol"
            ]
        );
    }
}

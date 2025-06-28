<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class FixAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Elimina cualquier usuario existente con ese correo
        User::where('email', 'admin@tagabi.com')->delete();

        // Crea uno nuevo limpio
        User::create([
            'name' => 'Tania Admin',
            'email' => 'admin@tagabi.com',
            'password' => Hash::make('12345678'),
            'rol' => 'admin',
        ]);
    }
}

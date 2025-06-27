<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TamanoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tamanos')->insert([
            ['nombre' => 'Sin Tamaño'],
            ['nombre' => 'Extra Pequeño'],
            ['nombre' => 'Pequeño'],
            ['nombre' => 'Mediano'],
            ['nombre' => 'Grande'],
            ['nombre' => 'Extra Grande'],
        ]);
    }
}

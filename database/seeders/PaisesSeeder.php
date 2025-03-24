<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaisesSeeder extends Seeder
{
    public function run()
    {
        DB::table('paises')->insert([
            'nombre' => 'Colombia',
            'estado' => 'Activo',
            'registradopor' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}

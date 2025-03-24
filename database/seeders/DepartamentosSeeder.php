<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DepartamentosSeeder extends Seeder
{
    public function run()
    {
        $url = 'https://geoportal.dane.gov.co/laboratorio/serviciosjson/gdivipola/servicios/departamentos.php';

        $response = Http::get($url);

        if ($response->successful()) {
            $json = $response->json();

            if (isset($json['resultado']) && is_array($json['resultado'])) {
                foreach ($json['resultado'] as $dep) {
                    DB::table('departamentos')->insert([
                        'pais_id' => 1,
                        'nombre' => mb_convert_case(trim($dep['NOMBRE_DEPARTAMENTO']), MB_CASE_TITLE, 'UTF-8'),
                        'codigo' => trim($dep['CODIGO_DEPARTAMENTO']), // ← ¡esto es clave!
                        'estado' => 'Activo',
                        'registradopor' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }

                $this->command->info('Departamentos insertados correctamente.');
            } else {
                $this->command->error('No se encontró el array "resultado" en el JSON.');
            }
        } else {
            $this->command->error('No se pudo obtener el JSON de departamentos desde el DANE.');
        }
    }
}


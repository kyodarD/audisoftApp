<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CiudadsSeeder extends Seeder
{
    public function run()
    {
        $url = 'https://geoportal.dane.gov.co/laboratorio/serviciosjson/gdivipola/servicios/municipios.php';

        $response = Http::get($url);

        if ($response->successful()) {
            $json = $response->json();

            if (isset($json['resultado']) && is_array($json['resultado'])) {
                foreach ($json['resultado'] as $mun) {
                    $codigoDepartamento = $mun['CODIGO_DEPARTAMENTO'];

                    // Buscar el departamento por código
                    $departamento = DB::table('departamentos')
                        ->where('codigo', $codigoDepartamento)
                        ->first();

                    if ($departamento) {
                        DB::table('ciudads')->insert([
                            'departamento_id' => $departamento->id,
                            'nombre' => mb_convert_case(trim($mun['NOMBRE_MUNICIPIO']), MB_CASE_TITLE, 'UTF-8'),
                            'estado' => 'Activo',
                            'registradopor' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    } else {
                        $this->command->warn("Departamento con código {$codigoDepartamento} no encontrado.");
                    }
                }

                $this->command->info('Ciudades insertadas correctamente.');
            } else {
                $this->command->error('El JSON no tiene el formato esperado.');
            }
        } else {
            $this->command->error('No se pudo obtener el JSON de municipios desde el DANE.');
        }
    }
}

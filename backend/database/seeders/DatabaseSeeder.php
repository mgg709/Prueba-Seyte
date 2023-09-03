<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Programador;
use App\Models\Sensor;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;


class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $faker = Faker::create();
    $currentDateTime = Carbon::now();
    $numero_serie = 0;
    for ($i = 0; $i < 1000; $i++) {
      $cliente = Cliente::create([
        'razon_social' => $faker->company,
        'cif' => $faker->unique()->regexify('[A-Z]{1}\d{7}[A-Z]{1}'),
        'direccion' => $faker->address,
        'municipio' => $faker->city,
        'provincia' => $faker->state,
        'fecha_inicio' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'fecha_expiracion' => $faker->date($format = 'Y-m-d', $max = '+5 years'),
      ]);


      for ($j = 0; $j < 30; $j++) {


        $programador = Programador::create([
          'numero_serie' => $numero_serie,
          'modelo' => $faker->randomElement(['A', 'B', 'C']),
          'fecha_alta' => $faker->date($format = 'Y-m-d', $max = 'now'),
          'fecha_ultima_conexion' => $faker->date($format = 'Y-m-d', $max = 'now'),
          'clientes_codigo' => $cliente->codigo,

        ]);

        $currentSensorDateTime = $currentDateTime->copy();
        for ($z = 0; $z < 1000; $z++) {
          Sensor::create([
            'sonda' => 'S1',
            'fecha_medida' => $currentSensorDateTime->toDateTimeString(),
            'valor' => $faker->randomFloat(2, 0, 100),
            'programadores_numero_serie' => $numero_serie,
          ]);
          Sensor::create([
            'sonda' => 'S2',
            'fecha_medida' => $currentSensorDateTime->toDateTimeString(),
            'valor' => $faker->randomFloat(2, 0, 100),
            'programadores_numero_serie' => $numero_serie,
          ]);
          Sensor::create([
            'sonda' => 'S3',
            'fecha_medida' => $currentSensorDateTime->toDateTimeString(),
            'valor' => $faker->randomFloat(2, 0, 100),
            'programadores_numero_serie' => $numero_serie,
          ]);
          Sensor::create([
            'sonda' => 'S4',
            'fecha_medida' => $currentSensorDateTime->toDateTimeString(),
            'valor' => $faker->randomFloat(2, 0, 100),
            'programadores_numero_serie' => $numero_serie,
          ]);
          $currentSensorDateTime->addMinutes(5);
        }
        $numero_serie += 1;
      }
    }
  }
}

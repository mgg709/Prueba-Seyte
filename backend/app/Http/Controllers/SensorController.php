<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SensorController extends Controller
{
  //
  public function indexByNumeroSerie(Request $request)
  {
    return Sensor::where('programadores_numero_serie', $request->numero_serie)->get();
  }

  public function registerMedida(Request $request)
  {
    $sensor = Sensor::create([
      'sonda' => $request->sonda,
      'fecha_medida' => Carbon::now()->format('Y-m-d H:i:s'),
      'valor' => rand(0, 100),
      'programadores_numero_serie' => $request->numero_serie
    ]);

    return response()->json($sensor, 201);
  }
}

<?php

namespace App\Http\Controllers;

use App\Models\Programador;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Sensor;
use Illuminate\Database\DBAL\TimestampType;

class ProgramadorController extends Controller
{
  //
  public function index(Request $request)
  {
    $codigo = $request->codigo;
    return Programador::where('clientes_codigo', $codigo)->get();
  }

  public function indexByFilter(Request $request)
  {
    $query = Programador::query()->where('clientes_codigo', $request->codigo);

    if ($request->modeloA) {
      $query->orWhere('modelo', 'like', '%' . $request->modeloA . '%');
    }
    if ($request->modeloB) {
      $query->orWhere('modelo', 'like', '%' . $request->modeloB . '%');
    }
    if ($request->modeloC) {
      $query->orWhere('modelo', 'like', '%' . $request->modeloC . '%');
    }

    $resultados = $query->get();
    return $resultados;
  }

  public function register(Request $request)
  {
    Cliente::findOrFail($request->clientes_codigo);
    $attributes = $request->validate([
      'modelo' => 'required',
      'fecha_alta' => 'required',
      'fecha_ultima_conexion' => 'required',
      'clientes_codigo' => 'required',
      'numero_serie' => 'required|unique:programadores'
    ]);
    $programador = Programador::create($attributes);
    $sensores = ['S1', 'S2', 'S3', 'S4'];
    foreach ($sensores as $sonda) {
      Sensor::create([
        'sonda' => $sonda,
        'fecha_medida' => now(),
        'valor' => rand(0, 100),
        'programadores_numero_serie' => $request->numero_serie
      ]);
    }
    return response()->json($programador, 201);
  }

  public function destroy($numero_serie)
  {
    $programador = Programador::findOrFail($numero_serie);
    $sensores_numero_serie = $programador->sensores()->pluck('programadores_numero_serie');
    Sensor::whereIn('programadores_numero_serie', $sensores_numero_serie)->delete();
    $programador->delete();
    return response()->json('Eliminado con éxito', 201);
  }
}

<?php

namespace App\Http\Controllers;

use App\Models\Programador;
use Illuminate\Http\Request;
use App\Models\Cliente;

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
    return response()->json($programador, 201);
  }

  public function update(Request $request, $id)
  {
    $programador = Programador::findOrFail($id);

    $programador->update($request);
    return response()->json($programador, 201);
  }

  public function destroy($numero_serie)
  {
    $programador = Programador::findOrFail($numero_serie);
    // $programador->sensores()->detach();
    $programador->delete();
    return response()->json('Eliminado con éxito', 201);
  }
}

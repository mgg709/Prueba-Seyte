<?php

namespace App\Http\Controllers;

use App\Models\Programador;
use Illuminate\Http\Request;

class ProgramadorController extends Controller
{
  //
  public function index($request)
  {
    $codigo = $request->codigo;
    return Programador::where('clientes_codigo', $codigo)->get();
  }

  public function register(Request $request)
  {
    $attributes = request()->validate([
      'modelo' => 'required',
      'fecha_alta' => 'required',
      'fecha_ultima_conexion' => 'required',
      'clientes_codigo' => 'required'
    ]);
    $programador = Programador::create($request->all());
    return response()->json($programador, 201);
  }

  public function update(Request $request, $id)
  {
    $programador = Programador::findOrFail($id);

    $programador->update($request);
    return response()->json($programador, 201);
  }

  public function destroy($id)
  {

    $programador = Programador::findOrFail($id);
    $programador->sensores()->detach();
    $programador->delete();
    return response()->json('Eliminado con éxito', 201);
  }
}

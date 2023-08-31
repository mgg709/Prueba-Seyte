<?php

namespace App\Http\Controllers;

use App\Models\Programador;
use Illuminate\Http\Request;

class ProgramadorController extends Controller
{
  //
  public function index($request)
  {
    $codigo = $request->razon;
    return Cliente::where('razon_social', 'like', '%' . $razon . '%')->get();
  }
  }

  public function register(Request $request)
  {
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

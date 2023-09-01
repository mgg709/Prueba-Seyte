<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
  //

  public function index()
  {
    return Cliente::all();
  }
  //TODO: Bug en el que si buscas con el campo vacio, te peta
  public function indexBySearch(Request $request)
  {
    if ($request->razon) {
      $razon = $request->razon;
      return Cliente::where('razon_social', 'like', '%' . $razon . '%')->get();
    }
    if ($request->municipio) {
      $municipio = $request->municipio;
      return Cliente::where('municipio', 'like', '%' . $municipio . '%')->get();
    }
    return response()->json('No se ha encontrado ningún cliente', 201);
  }

  public function indexByCodigo($codigo)
  {
    return Cliente::where('codigo', $codigo)->get();
  }

  public function register(Request $request)
  {
    $attributes = request()->validate([
      'razon_social' => 'required',
      'cif' => 'required',
      'direccion' => 'required',
      'municipio' => 'required',
      'provincia' => 'required',
      'fecha_inicio' => 'required',
      'fecha_expiracion' => 'required'
    ]);
    $client = Cliente::create($attributes);
    return response()->json($client, 201);
  }

  public function update(Request $request, $codigo)
  {
    $client = Cliente::findOrFail($codigo);
    $attributes = $request->validate([
      'razon_social' => 'required',
      'cif' => 'required',
      'direccion' => 'required',
      'municipio' => 'required',
      'provincia' => 'required',
      'fecha_inicio' => 'required',
      'fecha_expiracion' => 'required'
    ]);
    $client->update($attributes);
    return response()->json($client, 201);
  }

  public function destroy($codigo)
  {
    $client = Cliente::findOrFail($codigo);
    // $programadores = $client->programadores();
    // $programadores->sensores()->detach();
    // $programadores->detach();
    $client->delete();
    return response()->json('Eliminado con éxito', 201);
  }
}

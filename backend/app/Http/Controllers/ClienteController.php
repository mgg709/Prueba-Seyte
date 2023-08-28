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

  public function register(Request $request)
  {
    $client = Cliente::create($request->all());
    return response()->json($client, 201);
  }

  public function update(Request $request, $id)
  {
    $client = Cliente::findOrFail($id);

    $client->update($request);
    return response()->json($client, 201);
  }

  public function destroy($id)
  {

    $client = Cliente::findOrFail($id);
    $programadores = $client->programadores();
    $programadores->sensores()->detach();
    $programadores->detach();
    $client->delete();
    return response()->json('Eliminado con éxito', 201);
  }
}

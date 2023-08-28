<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;

class SensorController extends Controller
{
  //
  public function index()
  {
    return Sensor::all();
  }

  public function register(Request $request)
  {
    $sensor = Sensor::create($request->all());
    return response()->json($sensor, 201);
  }

  public function update(Request $request, $id)
  {
    $sensor = Sensor::findOrFail($id);

    $sensor->update($request);
    return response()->json($sensor, 201);
  }

  public function destroy($id)
  {

    $sensor = Sensor::findOrFail($id);
    $sensor->delete();
    return response()->json('Eliminado con éxito', 201);
  }
}

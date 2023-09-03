<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProgramadorController;
use App\Http\Controllers\SensorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});
Route::get('clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::get('clientes/search', [ClienteController::class, 'indexBySearch'])->name('clientes.indexBySearch');
Route::get('clientes/{codigo}', [ClienteController::class, 'indexByCodigo'])->name('clientes.indexByCodigo');
Route::post('clientes/register', [ClienteController::class, 'register'])->name('clientes.register');
Route::delete('clientes/delete/{codigo}', [ClienteController::class, 'destroy'])->name('clientes.delete');
Route::put('clientes/update/{codigo}', [ClienteController::class, 'update'])->name('clientes.update');

Route::get('programadores', [ProgramadorController::class, 'index'])->name('programadores.index');
Route::get('programadores/filter', [ProgramadorController::class, 'indexByFilter'])->name('programadores.indexByFilter');
Route::post('programadores/register', [ProgramadorController::class, 'register'])->name('programadores.register');
Route::delete('programadores/delete/{numero_serie}', [ProgramadorController::class, 'destroy'])->name('programadores.delete');
Route::put('programadores/update/{numero_serie}', [ProgramadorController::class, 'update'])->name('programadores.update');

Route::get('sensores', [SensorController::class, 'indexByNumeroSerie'])->name('sensores.index');
Route::post('sensores/medida', [SensorController::class, 'registerMedida'])->name('sensores.register');

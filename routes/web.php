<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IncidenciaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::controller(IncidenciaController::class)->group(function () {
    Route::get('/incidencias', [IncidenciaController::class, 'index']);
    Route::post('/incidencias', [IncidenciaController::class, 'store']);
    Route::get('/incidencias/{incidencia}', [IncidenciaController::class, 'show']);
    Route::patch('/incidencias/{incidencia}', [IncidenciaController::class, 'update']);
    Route::delete('/incidencias/{incidencia}', [IncidenciaController::class, 'destroy']);
});
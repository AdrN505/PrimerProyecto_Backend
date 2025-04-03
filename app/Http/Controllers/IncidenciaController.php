<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia;
use Illuminate\Http\JsonResponse;

class IncidenciaController extends Controller
{
    public function index(){
        return Incidencia::select('id', 'titulo', 'descripcion', 'urgencia')->get();
    }
    public function store(Request $request): JsonResponse
    {
        // Validar los datos
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'urgencia' => 'required|string|in:Baja,Media,Alta,Muy Alta',
        ]);

        // Crear la incidencia en la base de datos
        $incidencia = Incidencia::create($validated);

        return response()->json([
            "message" => "Incidencia creada",
            "incidencia" => $incidencia
        ], 201);
    }

/**
     * Mostrar una incidencia específica.
     *
     * @param  \App\Models\Incidencia  $incidencia
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Incidencia $incidencia): JsonResponse
    {
        return response()->json($incidencia);
    }

    /**
     * Actualizar una incidencia específica.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Incidencia  $incidencia
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Incidencia $incidencia): JsonResponse
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'urgencia' => 'required|string|in:Baja,Media,Alta,Muy Alta',
        ]);

        $incidencia->update($validatedData);
        
        return response()->json($incidencia);
    }

    /**
     * Eliminar una incidencia específica.
     *
     * @param  \App\Models\Incidencia  $incidencia
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Incidencia $incidencia): JsonResponse
    {
        $incidencia->delete();
        
        return response()->json(null, 204);
    }
}


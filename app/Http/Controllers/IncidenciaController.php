<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia;
use Illuminate\Http\JsonResponse;

class IncidenciaController extends Controller
{
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

        return json_encode(["message" => "Incidencia creada"]);
    }
}


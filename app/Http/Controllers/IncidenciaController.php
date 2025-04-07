<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia;
use Illuminate\Http\JsonResponse;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

class IncidenciaController extends Controller
{
    public function index(){
        return Incidencia::all();
    }
    public function store(Request $request): JsonResponse
    {
        // Validar los datos
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'urgencia' => 'required|string|in:Baja,Media,Alta,Muy Alta',
        ]);

        try{
            $incidencia = Incidencia::create($request->all());
            $subject = "Incidencia creada";
            $cuerpoMensaje = (object)[
                'titulo' => 'Nueva Incidencia',
                'detalles' => [
                    'id' => "ID $incidencia->id",
                    'descripcion' => "Descripcion : $incidencia->descripcion",
                    'urgencia' => "Urgencia : $incidencia->urgencia",
                ]
            ];
            $colorTitulo = "titulo-estandar";
            $this->enviarMail($subject,$cuerpoMensaje,$colorTitulo);

            return response()->json([
                "message" => $subject,
                "incidencia" => $incidencia
            ], 201);
        }
        catch(\Exception $e){
            return response()->json([
                "message" => $e->getMessage(),
            ], 403);
        }
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
        $id = $incidencia->id;
        $titulo = $incidencia->titulo;
        $incidencia->delete();
        $subject = "Incidencia Eliminada";
        $cuerpoMensaje = (object)[
            'titulo' => 'Se Ha Eliminado Una incidencia',
            'detalles' => [
                'id' => "ID : $id",
                'descripcion' => "Titulo : $titulo"
            ]
        ];
        $colorTitulo = "titulo-eliminado";
        $this->enviarMail($subject,$cuerpoMensaje,$colorTitulo);
        
        return response()->json(null, 204);
    }


    public function enviarMail($subject,$cuerpoMensaje,$colorTitulo){
        $mail = new TestMail($subject,$cuerpoMensaje,$colorTitulo);
        Mail::to('destinatario@example.com')->send($mail);
    }
}




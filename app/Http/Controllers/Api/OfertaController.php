<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Oferta;
use Illuminate\Http\Request;
use App\Http\Requests\OfertaRequest;
use Exception;

class OfertaController extends Controller
{
    public function index()
    {
        try {

            return response()->json([
                'success' => true,
                'data' => Oferta::all()
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las ofertas.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function store(OfertaRequest $request)
    {
        try {
            
            $oferta = Oferta::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Oferta registrada correctamente.',
                'data' => $oferta
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la oferta.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {

            $oferta = Oferta::find($id);

            if (!$oferta) {

                return response()->json([
                    'success' => false,
                    'message' => 'Oferta no encontrada.'
                ], 404);

            }

            return response()->json([
                'success' => true,
                'data' => $oferta
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al buscar la oferta.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function update(OfertaRequest $request, $id)
    {
        try {

            $oferta = Oferta::find($id);

            if (!$oferta) {

                return response()->json([
                    'success' => false,
                    'message' => 'Oferta no encontrada.'
                ], 404);

            }

            $oferta->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Oferta actualizada correctamente.',
                'data' => $oferta
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la oferta.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function destroy($id)
    {
        try {

            $oferta = Oferta::find($id);

            if (!$oferta) {

                return response()->json([
                    'success' => false,
                    'message' => 'Oferta no encontrada.'
                ], 404);

            }

            $oferta->delete();

            return response()->json([
                'success' => true,
                'message' => 'Oferta eliminada correctamente.'
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la oferta.',
                'error' => $e->getMessage()
            ], 500);

        }
    }
}
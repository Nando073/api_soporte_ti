<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CotizacionRequest;
use App\Models\Cotizacion;
use Exception;

class CotizacionController extends Controller
{
    public function index()
    {
        try {

            $cotizaciones = Cotizacion::with(['oferta', 'detalles'])->get();

            return response()->json([
                'success' => true,
                'data' => $cotizaciones
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las cotizaciones.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function store(CotizacionRequest $request)
    {
        try {

            $cotizacion = Cotizacion::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Cotización registrada correctamente.',
                'data' => $cotizacion
            ], 201);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la cotización.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function show($id)
    {
        try {

            $cotizacion = Cotizacion::with(['oferta', 'detalles'])->find($id);

            if (!$cotizacion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cotización no encontrada.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $cotizacion
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al buscar la cotización.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function update(CotizacionRequest $request, $id)
    {
        try {

            $cotizacion = Cotizacion::find($id);

            if (!$cotizacion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cotización no encontrada.'
                ], 404);
            }

            $cotizacion->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Cotización actualizada correctamente.',
                'data' => $cotizacion
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la cotización.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function destroy($id)
    {
        try {

            $cotizacion = Cotizacion::find($id);

            if (!$cotizacion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cotización no encontrada.'
                ], 404);
            }

            $cotizacion->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cotización eliminada correctamente.'
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la cotización.',
                'error' => $e->getMessage()
            ], 500);

        }
    }
}
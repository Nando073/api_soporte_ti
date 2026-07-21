<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetalleCotizacion;
use Illuminate\Http\Request;
use App\Http\Requests\DetalleCotizacionRequest;
use Exception;

class DetalleCotizacionController extends Controller
{
    public function index()
    {
        try {

            $detalles = DetalleCotizacion::with('cotizacion')->get();

            return response()->json([
                'success' => true,
                'data' => $detalles
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los detalles de cotización.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function store(DetalleCotizacionRequest $request)
    {
        try {

           

            $detalle = DetalleCotizacion::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Detalle de cotización registrado correctamente.',
                'data' => $detalle
            ], 201);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el detalle de cotización.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function show($id)
    {
        try {

            $detalle = DetalleCotizacion::with('cotizacion')->find($id);

            if (!$detalle) {

                return response()->json([
                    'success' => false,
                    'message' => 'Detalle de cotización no encontrado.'
                ], 404);

            }

            return response()->json([
                'success' => true,
                'data' => $detalle
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al buscar el detalle de cotización.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function update(DetalleCotizacionRequest $request, $id)
    {
        try {

            $detalle = DetalleCotizacion::find($id);

            if (!$detalle) {

                return response()->json([
                    'success' => false,
                    'message' => 'Detalle de cotización no encontrado.'
                ], 404);

            }

            $detalle->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Detalle de cotización actualizado correctamente.',
                'data' => $detalle
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el detalle de cotización.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function destroy($id)
    {
        try {

            $detalle = DetalleCotizacion::find($id);

            if (!$detalle) {

                return response()->json([
                    'success' => false,
                    'message' => 'Detalle de cotización no encontrado.'
                ], 404);

            }

            $detalle->delete();

            return response()->json([
                'success' => true,
                'message' => 'Detalle de cotización eliminado correctamente.'
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el detalle de cotización.',
                'error' => $e->getMessage()
            ], 500);

        }
    }
}
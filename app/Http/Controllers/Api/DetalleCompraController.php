<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetalleCompra;
use App\Http\Requests\DetalleCompraRequest;
use Exception;

class DetalleCompraController extends Controller
{
    public function index()
    {
        try {
            // Nota: Si aún no tienes el modelo Repuesto, dejamos solo 'compra'
            $detalles = DetalleCompra::with('compra')->get();

            return response()->json([
                'success' => true,
                'data' => $detalles
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los detalles de compra.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(DetalleCompraRequest $request)
    {
        try {
            $detalle = DetalleCompra::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Detalle de compra registrado correctamente.',
                'data' => $detalle
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el detalle de compra.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $detalle = DetalleCompra::with('compra')->find($id);

            if (!$detalle) {
                return response()->json([
                    'success' => false,
                    'message' => 'Detalle de compra no encontrado.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $detalle
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar el detalle de compra.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(DetalleCompraRequest $request, $id)
    {
        try {
            $detalle = DetalleCompra::find($id);

            if (!$detalle) {
                return response()->json([
                    'success' => false,
                    'message' => 'Detalle de compra no encontrado.'
                ], 404);
            }

            // Cambiado a validated() por seguridad
            $detalle->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Detalle de compra actualizado correctamente.',
                'data' => $detalle
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el detalle de compra.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $detalle = DetalleCompra::find($id);

            if (!$detalle) {
                return response()->json([
                    'success' => false,
                    'message' => 'Detalle de compra no encontrado.'
                ], 404);
            }

            $detalle->delete();

            return response()->json([
                'success' => true,
                'message' => 'Detalle de compra eliminado correctamente.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el detalle de compra.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
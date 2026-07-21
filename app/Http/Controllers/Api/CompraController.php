<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Http\Requests\CompraRequest;  
use Exception;

class CompraController extends Controller
{
    // GET - Listar compras
    public function index()
    {
        try {
            // Excelente cambio agregando las relaciones como arreglos o strings separados por comas
            $compras = Compra::with(['proveedor', 'detalles'])->get();

            return response()->json([
                'success' => true,
                'data' => $compras
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las compras.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // POST - Registrar compra
    public function store(CompraRequest $request) // ✅ Cambiado de Request a StoreCompraRequest
    {
        try {
            // Ahora sí funcionará de forma segura con datos validados
            $compra = Compra::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Compra registrada correctamente.',
                'data' => $compra
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la compra.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET - Buscar compra por ID
    public function show($id)
    {
        try {
            $compra = Compra::with(['proveedor', 'detalles'])->find($id);

            if (!$compra) {
                return response()->json([
                    'success' => false,
                    'message' => 'Compra no encontrada.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $compra
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar la compra.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // PUT - Actualizar compra
    public function update(CompraRequest $request, $id) // ✅ Cambiado de Request a UpdateCompraRequest
    {
        try {
            $compra = Compra::find($id);

            if (!$compra) {
                return response()->json([
                    'success' => false,
                    'message' => 'Compra no encontrada.'
                ], 404);
            }

            $compra->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Compra actualizada correctamente.',
                'data' => $compra
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la compra.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // DELETE - Eliminar compra
    public function destroy($id)
    {
        try {
            $compra = Compra::find($id);

            if (!$compra) {
                return response()->json([
                    'success' => false,
                    'message' => 'Compra no encontrada.'
                ], 404);
            }

            $compra->delete();

            return response()->json([
                'success' => true,
                'message' => 'Compra eliminada correctamente.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la compra.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
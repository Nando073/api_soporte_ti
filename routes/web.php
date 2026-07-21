<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

Route::get('/', function () {
    return view('welcome');
});

// ========== RUTAS SWAGGER ==========

// 1. Servir el JSON directamente en /docs (lo que la UI espera)
Route::get('/docs', function () {
    $jsonPath = storage_path('api-docs/api-docs.json');
    
    // Si no existe, generarlo automáticamente
    if (!File::exists($jsonPath)) {
        try {
            $openapi = \OpenApi\Generator::scan([
                app_path('Http/Controllers'),
                app_path('Swagger')
            ]);
            
            $json = $openapi->toJson();
            
            // Asegurar que el directorio existe
            if (!File::exists(dirname($jsonPath))) {
                File::makeDirectory(dirname($jsonPath), 0777, true);
            }
            
            File::put($jsonPath, $json);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generando documentación',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    if (!File::exists($jsonPath)) {
        return response()->json([
            'error' => 'Documentación no encontrada'
        ], 404);
    }
    
    // Devolver el archivo JSON con el tipo de contenido correcto
    return response()->file($jsonPath, [
        'Content-Type' => 'application/json'
    ]);
});

// 2. Servir el JSON también en /api-docs.json (para acceso directo)
Route::get('/api-docs.json', function () {
    $jsonPath = storage_path('api-docs/api-docs.json');
    
    if (File::exists($jsonPath)) {
        return response()->file($jsonPath, [
            'Content-Type' => 'application/json'
        ]);
    }
    
    // Si no existe, redirigir a /docs para que lo genere
    return redirect()->to('/docs');
});

// ========== TUS RUTAS API ==========
// Aquí van tus rutas de API
// Route::prefix('api')->group(function () {
//     Route::apiResource('proveedores', ProveedorController::class);
//     // ... más rutas
// });
<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //

            // El número de documento es obligatorio, texto único en la tabla compras
            'n_documento'  => 'required|string|max:50|unique:compras,n_documento',
            
            // Validamos que los IDs sean enteros y existan en sus respectivas tablas
            'id_proveedor' => 'required|integer|exists:proveedores,id_proveedor',
            'id_usuario'   => 'required|integer|exists:usuarios,id_usuario',
            
            // El total debe ser un valor numérico positivo
            'total_compra' => 'required|numeric|min:0',
            
            // Forma de pago (ej: 'Efectivo', 'Transferencia', 'Crédito')
            'forma_pago'   => 'required|string|max:50',
            
            // La observación es opcional
            'observacion'  => 'nullable|string',
            
            // Fecha con formato YYYY-MM-DD
            'fecha'        => 'required|date|date_format:Y-m-d',
            
            // El estado es opcional (por defecto 1 en la BD) o un booleano/tinyint
            'estado'       => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'required'             => 'El campo :attribute es obligatorio.',
            'n_documento.unique'   => 'El número de documento ya está registrado en otra compra.',
            'exists'               => 'El :attribute ingresado no existe en la base de datos.',
            'total_compra.numeric' => 'El total de la compra debe ser un valor numérico.',
            'date_format'          => 'La fecha debe tener el formato YYYY-MM-DD.',
        ];
    }
}

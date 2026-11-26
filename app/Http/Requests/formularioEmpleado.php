<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class formularioEmpleado extends FormRequest
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
            'telefono' =>['required' , 'regex:/^[6789]\d{8}$/']
        ];
    }


    public function messages(): array
    {
        return [
            'telefono.required' => 'El telefono es un campo obligatorio',
            'telefono.regex' => 'El telefono no cumple con los estandares de España'
        ];
    }
}

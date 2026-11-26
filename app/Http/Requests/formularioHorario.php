<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class formularioHorario extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        $localUsuario = $this->user()->ID_Local;
        $bloquesHoraPermitidos = [
            '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
            '12:00', '12:30', '13:00', '13:30', '14:00', '14:30',
            '15:00', '15:30', '16:00', '16:30', '17:00', '17:30',
            '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00'
        ];
        return [
            'dia' => ['required', 'date' , 'after_or_equal:today'],
            'horarios' => ['required', 'array'],
            'horarios.*' => [
                'nullable',
                'integer',
                Rule::exists('empleados', 'id')->where(function ($query) use ($localUsuario) {
                    $query->where('ID_Local', $localUsuario);
                }),
                function ($attribute, $value, $fail) use ($bloquesHoraPermitidos) {
                    $hora = str_replace('horarios.', '', $attribute);

                    if (!in_array($hora, $bloquesHoraPermitidos, true)) {
                        $fail("Tramo {$hora} no permitido.");
                    }
                },
            ],
        ];
    }
}

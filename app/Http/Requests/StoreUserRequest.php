<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // 1 = Male, 2 = Female (aceita inteiro ou string numérica)
            'genero' => ['nullable', 'integer', 'in:1,2'],
            'fotografia' => ['nullable', 'image', 'max:2048'],
            'cargo_id' => ['nullable', 'integer', Rule::exists('positions', 'id')],
            'departamento_id' => ['nullable', 'integer', Rule::exists('departments', 'id')],
        ];
    }

    /** Normaliza género para inteiro quando enviado como string numérica. */
    protected function prepareForValidation(): void
    {
        if ($this->has('genero') && $this->genero !== null && $this->genero !== '') {
            if (is_numeric($this->genero)) {
                $this->merge(['genero' => (int) $this->genero]);
            }
        }
    }
}

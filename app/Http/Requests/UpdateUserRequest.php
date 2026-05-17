<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id ?? $this->route('user');

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'genero' => ['nullable', 'integer', 'in:1,2'],
            'fotografia' => ['nullable', 'image', 'max:2048'],
            'cargo_id' => ['nullable', 'integer', Rule::exists('positions', 'id')],
            'departamento_id' => ['nullable', 'integer', Rule::exists('departments', 'id')],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('genero') && $this->genero !== null && $this->genero !== '') {
            if (is_numeric($this->genero)) {
                $this->merge(['genero' => (int) $this->genero]);
            }
        }
    }
}

<?php

namespace App\Http\Requests;

class RegisterRequest extends StoreUserRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        // No registo, a password é sempre obrigatória.
        $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];

        return $rules;
    }
}

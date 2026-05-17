<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at?->toISOString(),
            'genero' => $this->genero,
            'genero_label' => $this->generoLabel(),
            'fotografia' => $this->fotografiaUrl(),
            'cargo_id' => $this->cargo_id,
            'departamento_id' => $this->departamento_id,
            'cargo' => PositionResource::make($this->whenLoaded('cargo')),
            'departamento' => DepartmentResource::make($this->whenLoaded('departamento')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }

    /** URL pública da fotografia, se existir. */
    protected function fotografiaUrl(): ?string
    {
        if (! $this->fotografia) {
            return null;
        }

        if (filter_var($this->fotografia, FILTER_VALIDATE_URL)) {
            return $this->fotografia;
        }

        return Storage::disk('public')->url($this->fotografia);
    }

    /** Etiqueta legível do género (1 = Male, 2 = Female). */
    protected function generoLabel(): ?string
    {
        return match ($this->genero) {
            1 => 'Male',
            2 => 'Female',
            default => null,
        };
    }
}

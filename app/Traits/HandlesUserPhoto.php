<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HandlesUserPhoto
{
    /**
     * Guarda a fotografia no disco público e devolve o caminho relativo.
     */
    protected function storeUserPhoto(?UploadedFile $file): ?string
    {
        if ($file === null) {
            return null;
        }

        return $file->store('fotografias', 'public');
    }

    /**
     * Remove a fotografia antiga do storage, se existir.
     */
    protected function deleteUserPhoto(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}

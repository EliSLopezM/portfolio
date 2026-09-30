<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

/**
 * Resuelve URLs de archivos: subidos desde el dashboard ("uploads/...")
 * o heredados del repositorio (carpeta pública `$legacyDir`).
 */
class Media
{
    public const UPLOAD_PREFIX = 'uploads/';

    public static function url(?string $value, string $legacyDir = 'images'): ?string
    {
        if (blank($value)) {
            return null;
        }

        if (preg_match('#^(https://|data:image/)#i', $value)) {
            return $value;
        }

        if (str_starts_with($value, self::UPLOAD_PREFIX)) {
            return Storage::disk(config('admin.uploads_disk'))->url(substr($value, strlen(self::UPLOAD_PREFIX)));
        }

        return asset(trim($legacyDir, '/').'/'.ltrim($value, '/'));
    }

    public static function isUpload(?string $value): bool
    {
        return $value && str_starts_with($value, self::UPLOAD_PREFIX);
    }
}

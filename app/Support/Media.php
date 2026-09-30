<?php

namespace App\Support;

/**
 * Resuelve URLs de archivos: subidos desde el dashboard (guardados en la base de datos) ("uploads/...")
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
            return '/files/'.self::fileName($value);
        }

        return asset(trim($legacyDir, '/').'/'.ltrim($value, '/'));
    }

    public static function fileName(string $path): string
    {
        return substr($path, strlen(self::UPLOAD_PREFIX));
    }

    public static function isUpload(?string $value): bool
    {
        return $value && str_starts_with($value, self::UPLOAD_PREFIX);
    }
}

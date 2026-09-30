<?php

namespace App\Services;

use App\Support\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    public const IMAGE_RULES = ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120', 'dimensions:max_width=6000,max_height=6000'];

    public const PDF_RULES = ['file', 'mimes:pdf', 'mimetypes:application/pdf', 'max:10240'];

    public const VIDEO_RULES = ['file', 'mimetypes:video/mp4,video/webm', 'max:51200'];

    private function disk()
    {
        return Storage::disk(config('admin.uploads_disk'));
    }

    /** Guarda con nombre aleatorio y extensión detectada por contenido (nunca la del cliente). */
    public function store(UploadedFile $file, string $folder): string
    {
        $name = $file->hashName();
        $extension = $file->guessExtension() ?: 'bin';
        $name = pathinfo($name, PATHINFO_FILENAME).'.'.$extension;

        $this->disk()->putFileAs($folder, $file, $name);

        return Media::UPLOAD_PREFIX.$folder.'/'.$name;
    }

    /** Reemplaza un archivo anterior (si era una subida) por uno nuevo. */
    public function replace(?UploadedFile $file, ?string $current, string $folder): ?string
    {
        if (! $file) {
            return $current;
        }

        $this->delete($current);

        return $this->store($file, $folder);
    }

    public function delete(?string $path): void
    {
        if (! Media::isUpload($path) || str_contains($path, '..')) {
            return;
        }

        $this->disk()->delete(substr($path, strlen(Media::UPLOAD_PREFIX)));
    }
}

<?php

namespace App\Services;

use App\Models\StoredFile;
use App\Support\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/** Guarda archivos subidos en la base de datos (tabla stored_files) y devuelve su referencia «uploads/{nombre}». */
class UploadService
{
    public const PDF_RULES = ['file', 'mimes:pdf', 'mimetypes:application/pdf', 'max:10240'];

    public function __construct(private ImageProcessor $images) {}

    /** Reglas de validación de una imagen (el tamaño final lo define el preset). */
    public static function imageRules(): array
    {
        return ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:'.config('images.max_upload_kb'), 'dimensions:max_width=8000,max_height=8000'];
    }

    public function storeImage(UploadedFile $file, string $preset): string
    {
        $img = $this->images->process($file, $preset);

        return $this->save($img['data'], $img['mime'], $img['ext'], $preset, $img['width'], $img['height']);
    }

    public function storePdf(UploadedFile $file): string
    {
        return $this->save((string) file_get_contents($file->getRealPath()), 'application/pdf', 'pdf', 'pdf');
    }

    public function replaceImage(?UploadedFile $file, ?string $current, string $preset): ?string
    {
        if (! $file) {
            return $current;
        }

        $this->delete($current);

        return $this->storeImage($file, $preset);
    }

    public function replacePdf(?UploadedFile $file, ?string $current): ?string
    {
        if (! $file) {
            return $current;
        }

        $this->delete($current);

        return $this->storePdf($file);
    }

    public function delete(?string $path): void
    {
        if (Media::isUpload($path)) {
            StoredFile::where('name', Media::fileName($path))->delete();
        }
    }

    private function save(string $binary, string $mime, string $ext, string $folder, ?int $w = null, ?int $h = null): string
    {
        $name = Str::random(40).'.'.$ext;

        StoredFile::create([
            'name' => $name, 'folder' => $folder, 'mime' => $mime, 'size' => strlen($binary),
            'width' => $w, 'height' => $h, 'data' => base64_encode($binary),
        ]);

        return Media::UPLOAD_PREFIX.$name;
    }
}

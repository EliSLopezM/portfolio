<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use InvalidArgumentException;

/** Ajusta imágenes a los tamaños de config/images.php, corrige la rotación EXIF y las guarda en WebP. */
class ImageProcessor
{
    public static function preset(string $name): array
    {
        return config("images.presets.$name") ?? throw new InvalidArgumentException("Preset de imagen desconocido: $name");
    }

    /** @return array{data: string, mime: string, ext: string, width: int, height: int} */
    public function process(UploadedFile $file, string $presetName): array
    {
        $preset = self::preset($presetName);
        $path = $file->getRealPath();
        $source = @imagecreatefromstring((string) file_get_contents($path));

        if (! $source) {
            throw new InvalidArgumentException('La imagen no se pudo leer.');
        }

        $source = $this->applyExifOrientation($source, $path);
        [$sw, $sh] = [imagesx($source), imagesy($source)];

        [$tw, $th] = $this->targetSize($sw, $sh, $preset);
        $canvas = imagecreatetruecolor($tw, $th);
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        imagefill($canvas, 0, 0, imagecolorallocatealpha($canvas, 0, 0, 0, 127));

        if ($preset['mode'] === 'cover') {
            $scale = max($tw / $sw, $th / $sh);
            $cw = (int) round($tw / $scale);
            $ch = (int) round($th / $scale);
            imagecopyresampled($canvas, $source, 0, 0, (int) (($sw - $cw) / 2), (int) (($sh - $ch) / 2), $tw, $th, $cw, $ch);
        } else {
            imagecopyresampled($canvas, $source, 0, 0, 0, 0, $tw, $th, $sw, $sh);
        }

        ob_start();
        imagewebp($canvas, null, (int) config('images.quality', 82));
        $data = (string) ob_get_clean();

        return ['data' => $data, 'mime' => 'image/webp', 'ext' => 'webp', 'width' => $tw, 'height' => $th];
    }

    /** cover: tamaño exacto del marco; fit: reduce manteniendo proporción y nunca agranda. */
    private function targetSize(int $sw, int $sh, array $preset): array
    {
        if ($preset['mode'] === 'cover') {
            return [$preset['w'], $preset['h']];
        }

        $scale = min(1, $preset['w'] / $sw, ($preset['h'] ?? PHP_INT_MAX) / $sh);

        return [max(1, (int) round($sw * $scale)), max(1, (int) round($sh * $scale))];
    }

    private function applyExifOrientation(\GdImage $image, string $path): \GdImage
    {
        if (! function_exists('exif_read_data')) {
            return $image;
        }

        $orientation = @exif_read_data($path)['Orientation'] ?? 1;
        $angle = [3 => 180, 6 => -90, 8 => 90][$orientation] ?? 0;

        return $angle ? (imagerotate($image, $angle, 0) ?: $image) : $image;
    }
}

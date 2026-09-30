<?php

namespace App\Http\Controllers;

use App\Models\StoredFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/** Sirve los archivos subidos que viven en la base de datos, con caché larga (los nombres son únicos). */
class FileController extends Controller
{
    public function show(Request $request, string $name): Response
    {
        abort_unless(preg_match('/^[A-Za-z0-9]{40}\.(webp|pdf)$/', $name), 404);

        $meta = StoredFile::where('name', $name)->first(['id', 'mime', 'size', 'updated_at']);
        abort_unless($meta, 404);

        $etag = '"'.md5($name.$meta->size).'"';
        $headers = [
            'Content-Type' => $meta->mime,
            'Cache-Control' => 'public, max-age=31536000, immutable',
            'ETag' => $etag,
            'X-Content-Type-Options' => 'nosniff',
            'Content-Disposition' => 'inline; filename="'.$name.'"',
            'Cross-Origin-Resource-Policy' => 'same-origin',
        ];

        if ($meta->mime !== 'application/pdf') {
            $headers['Content-Security-Policy'] = "default-src 'none'; style-src 'unsafe-inline'; sandbox";
        }

        if ($request->headers->get('If-None-Match') === $etag) {
            return response('', 304, $headers);
        }

        return response(StoredFile::findOrFail($meta->id)->binary(), 200, $headers);
    }
}

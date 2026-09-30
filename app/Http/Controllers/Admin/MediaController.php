<?php

namespace App\Http\Controllers\Admin;

use App\Models\MediaItem;
use App\Services\UploadService;
use Illuminate\Http\Request;

class MediaController extends AdminController
{
    public function __construct(private UploadService $uploads) {}

    public function index()
    {
        return $this->view('admin.media.index', [
            'items' => MediaItem::where('scope', $this->area())->ordered()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'images' => ['required', 'array', 'max:20'],
            'images.*' => UploadService::IMAGE_RULES,
            'title' => ['nullable', 'string', 'max:120'],
            'alt' => ['nullable', 'string', 'max:160'],
        ]);

        foreach ($request->file('images') as $file) {
            MediaItem::create([
                'scope' => $this->area(),
                'title' => $request->input('title'),
                'alt' => $request->input('alt'),
                'path' => $this->uploads->store($file, 'media/'.$this->area()),
            ]);
        }

        return back()->with('status', 'Imágenes subidas.');
    }

    public function update(Request $request, MediaItem $media)
    {
        abort_unless($media->scope === $this->area(), 404);

        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:120'],
            'alt' => ['nullable', 'string', 'max:160'],
            'image' => ['nullable', ...UploadService::IMAGE_RULES],
        ]);

        $media->update([
            'title' => $data['title'] ?? null,
            'alt' => $data['alt'] ?? null,
            'path' => $this->uploads->replace($request->file('image'), $media->path, 'media/'.$this->area()),
        ]);

        return back()->with('status', 'Imagen actualizada.');
    }

    public function destroy(MediaItem $media)
    {
        abort_unless($media->scope === $this->area(), 404);

        $this->uploads->delete($media->path);
        $media->delete();

        return back()->with('status', 'Imagen eliminada.');
    }
}

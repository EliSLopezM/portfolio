<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Services\SeoGenerator;
use App\Services\UploadService;
use App\Support\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends AdminController
{
    public function __construct(private UploadService $uploads) {}

    public function index(Request $request)
    {
        $posts = Post::forArea($this->area())
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.addcslashes($request->string('q'), '%_\\').'%'))
            ->when($request->input('estado') === 'publicado', fn ($q) => $q->where('published', true))
            ->when($request->input('estado') === 'borrador', fn ($q) => $q->where('published', false))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return $this->view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return $this->form(new Post(['author' => config('admin.author'), 'published' => false]));
    }

    public function store(Request $request)
    {
        $post = new Post(['author' => config('admin.author')]);
        $this->fill($post, $request);

        return redirect($this->to('posts.edit', $post))->with('status', 'Blog guardado.');
    }

    public function edit(Post $post)
    {
        abort_unless($post->isDcc() === ($this->area() === 'dcc'), 404);

        return $this->form($post);
    }

    public function update(Request $request, Post $post)
    {
        abort_unless($post->isDcc() === ($this->area() === 'dcc'), 404);
        $this->fill($post, $request);

        return redirect($this->to('posts.edit', $post))->with('status', 'Blog actualizado.');
    }

    public function destroy(Post $post)
    {
        abort_unless($post->isDcc() === ($this->area() === 'dcc'), 404);

        $this->uploads->delete($post->cover_image);
        $this->uploads->delete($post->video_path);
        $post->delete();

        return redirect($this->to('posts.index'))->with('status', 'Blog eliminado.');
    }

    /** Sugerencia SEO en vivo para el editor (no guarda nada). */
    public function seo(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:200'], 'excerpt' => ['nullable', 'string', 'max:400'],
            'content' => ['nullable', 'string', 'max:200000'], 'category' => ['nullable', 'string', 'max:40'],
        ]);

        return response()->json([
            'title' => SeoGenerator::title($data['title'] ?? ''),
            'description' => SeoGenerator::description($data['excerpt'] ?? '', $data['content'] ?? ''),
            'keywords' => SeoGenerator::keywords($data['title'] ?? '', $data['category'] ?? 'general', $data['excerpt'] ?? '', $data['content'] ?? ''),
            'minutes' => SeoGenerator::readingMinutes($data['content'] ?? ''),
        ]);
    }

    /** Imagen insertada dentro del cuerpo del artículo. */
    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate(['image' => ['required', ...UploadService::IMAGE_RULES]]);

        $path = $this->uploads->store($request->file('image'), 'blog/inline');

        return response()->json(['url' => Media::url($path)]);
    }

    private function form(Post $post)
    {
        return $this->view('admin.posts.form', [
            'post' => $post,
            'categories' => config('admin.post_categories.'.$this->area()),
        ]);
    }

    private function fill(Post $post, Request $request): void
    {
        $categories = array_keys(config('admin.post_categories.'.$this->area()));

        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:160', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'],
            'excerpt' => ['required', 'string', 'max:300'],
            'content' => ['required', 'string', 'max:200000'],
            'category' => ['required', Rule::in($categories)],
            'published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'cover' => ['nullable', ...UploadService::IMAGE_RULES],
            'remove_cover' => ['boolean'],
            'video_url' => ['nullable', 'url:https', 'max:255', 'regex:#^https://(www\.)?(youtube\.com/(watch\?|shorts/)|youtu\.be/|vimeo\.com/\d)#'],
            'video' => ['nullable', ...UploadService::VIDEO_RULES],
            'remove_video' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:170'],
            'keywords' => ['nullable', 'string', 'max:255'],
        ], [
            'video_url.regex' => 'Usa un enlace de YouTube o Vimeo (https).',
        ]);

        $cover = $request->boolean('remove_cover') ? null : $post->cover_image;
        if ($request->boolean('remove_cover')) {
            $this->uploads->delete($post->cover_image);
        }

        $videoPath = $request->boolean('remove_video') ? null : $post->video_path;
        if ($request->boolean('remove_video')) {
            $this->uploads->delete($post->video_path);
        }

        $published = $request->boolean('published');

        $post->fill([
            'title' => $data['title'],
            'slug' => $post->exists
                ? Post::uniqueSlug($data['slug'] ?? $post->slug, $post->id)
                : ($data['slug'] ?? null),
            'excerpt' => $data['excerpt'],
            'content' => $data['content'],
            'category' => $data['category'],
            'cover_image' => $this->uploads->replace($request->file('cover'), $cover, 'blog'),
            'video_url' => $data['video_url'] ?? null,
            'video_path' => $this->uploads->replace($request->file('video'), $videoPath, 'blog/video'),
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'keywords' => $data['keywords'] ?? null,
            'published' => $published,
            'published_at' => $published ? ($data['published_at'] ?? $post->published_at ?? now()) : ($data['published_at'] ?? $post->published_at),
        ])->save();
    }
}

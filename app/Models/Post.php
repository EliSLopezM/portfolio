<?php

namespace App\Models;

use App\Services\SeoGenerator;
use App\Support\Media;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'category', 'author',
        'cover_image', 'video_url',
        'meta_title', 'meta_description', 'keywords',
        'published', 'published_at',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
        'likes' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            $post->slug = static::uniqueSlug($post->slug ?: $post->title);
        });
    }

    public static function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = Str::slug($base) ?: 'articulo';
        $candidate = $slug;
        $i = 2;

        while (static::where('slug', $candidate)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $candidate = $slug.'-'.$i++;
        }

        return $candidate;
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true)->orderBy('published_at', 'desc');
    }

    public function scopeForArea(Builder $query, string $area): Builder
    {
        return $area === 'dcc'
            ? $query->where('category', 'like', 'dcc-%')
            : $query->where('category', 'not like', 'dcc-%');
    }

    public function isDcc(): bool
    {
        return str_starts_with($this->category, 'dcc-');
    }

    public function publicUrl(): string
    {
        return route($this->isDcc() ? 'dcc.blog.show' : 'blog.show', $this->slug);
    }

    /** El contenido se sanitiza al guardar: solo etiquetas permitidas, sin scripts ni handlers. */
    public function setContentAttribute(?string $value): void
    {
        $this->attributes['content'] = Purify::clean((string) $value);
    }

    /** Contenido listo para imprimir; los artículos antiguos en texto plano conservan sus saltos de línea. */
    public function renderedContent(): HtmlString
    {
        $content = (string) $this->content;

        if ($content === strip_tags($content)) {
            return new HtmlString(nl2br(e($content)));
        }

        return new HtmlString($content);
    }

    public function coverUrl(): ?string
    {
        if (blank($this->cover_image) || Media::isUpload($this->cover_image)) {
            return Media::url($this->cover_image);
        }

        return Media::url($this->cover_image, file_exists(public_path('images/blog/'.$this->cover_image)) ? 'images/blog' : 'images');
    }

    /** ID de YouTube / Vimeo convertido en URL de embed segura (lista blanca de hosts). */
    public function videoEmbedUrl(): ?string
    {
        if (blank($this->video_url)) {
            return null;
        }

        $url = $this->video_url;

        if (preg_match('#^https://(?:www\.)?(?:youtube\.com/watch\?(?:.*&)?v=|youtu\.be/|youtube\.com/shorts/)([\w-]{11})#', $url, $m)) {
            return 'https://www.youtube-nocookie.com/embed/'.$m[1];
        }

        if (preg_match('#^https://(?:www\.)?vimeo\.com/(\d+)#', $url, $m)) {
            return 'https://player.vimeo.com/video/'.$m[1];
        }

        return null;
    }

    public function seoTitle(): string
    {
        return SeoGenerator::title($this->title, $this->meta_title);
    }

    public function seoDescription(): string
    {
        return SeoGenerator::description((string) $this->excerpt, (string) $this->content, $this->meta_description);
    }

    public function seoKeywords(): string
    {
        return SeoGenerator::keywords($this->title, $this->category, (string) $this->excerpt, (string) $this->content, $this->keywords);
    }

    public function readingMinutes(): int
    {
        return SeoGenerator::readingMinutes((string) $this->content);
    }

    /** Datos estructurados schema.org BlogPosting. */
    public function jsonLd(): array
    {
        $image = $this->coverUrl() ?: asset('images/elilogo.png');

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $this->seoTitle(),
            'description' => $this->seoDescription(),
            'image' => [$image],
            'keywords' => $this->seoKeywords(),
            'wordCount' => str_word_count(SeoGenerator::plainText($this->content)),
            'inLanguage' => 'es-CO',
            'articleSection' => $this->category,
            'datePublished' => $this->published_at?->toIso8601String(),
            'dateModified' => $this->updated_at?->toIso8601String(),
            'mainEntityOfPage' => $this->publicUrl(),
            'author' => ['@type' => 'Person', 'name' => $this->author],
            'publisher' => ['@type' => 'Person', 'name' => config('portfolio.name'), 'url' => config('app.url')],
            'interactionStatistic' => [
                ['@type' => 'InteractionCounter', 'interactionType' => 'https://schema.org/LikeAction', 'userInteractionCount' => $this->likes],
                ['@type' => 'InteractionCounter', 'interactionType' => 'https://schema.org/ViewAction', 'userInteractionCount' => $this->views],
            ],
        ]);
    }
}

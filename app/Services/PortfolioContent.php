<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\MediaItem;
use App\Models\Project;
use App\Models\Setting;
use App\Models\StackCategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Entrega el contenido público del portafolio con la misma forma que config/portfolio.php,
 * tomando de la base de datos lo que se administra desde el dashboard.
 */
class PortfolioContent
{
    private const CACHE_KEY = 'portfolio.content';

    public static function get(): array
    {
        try {
            return Cache::rememberForever(self::CACHE_KEY, fn () => self::build());
        } catch (\Throwable $e) {
            Log::error('No se pudo cargar el contenido desde la base de datos: '.$e->getMessage());

            return self::fromConfig();
        }
    }

    /** Contenido estático de config/portfolio.php con la misma forma que el de la base de datos. */
    private static function fromConfig(): array
    {
        $data = config('portfolio');

        $data['stack'] = array_map(function (array $tech) {
            if (($tech['level'] ?? null) === 'conocimiento') {
                $tech['level'] = 'estudio';
            }

            return $tech;
        }, $data['stack']);

        $data['projects'] = array_map(fn (array $p) => $p + [
            'image_url' => ! empty($p['image']) && file_exists(public_path('images/'.$p['image'])) ? asset('images/'.$p['image']) : null,
        ], $data['projects']);

        $data['certs'] = array_map(fn (array $c) => $c + [
            'pdf_url' => asset('images/certs/'.$c['pdf']),
            'preview_url' => ! empty($c['preview']) ? asset('images/certs/'.$c['preview']) : null,
        ], $data['certs']);

        $data['gallery'] = [];

        return $data;
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public static function gallery(string $scope): array
    {
        return MediaItem::where('scope', $scope)->visible()->ordered()->get()
            ->map(fn (MediaItem $m) => ['url' => $m->url(), 'alt' => $m->alt ?: $m->title ?: 'Imagen', 'title' => $m->title])
            ->all();
    }

    private static function build(): array
    {
        $data = self::fromConfig();

        foreach (Setting::all()->pluck('value', 'key') as $key => $value) {
            if ($value !== null && $value !== '') {
                $data[$key] = $value;
            }
        }

        $categories = StackCategory::visible()->ordered()->with(['items' => fn ($q) => $q->visible()])->get();

        if ($categories->isNotEmpty()) {
            $data['stack_categories'] = $categories->map(fn ($c) => [
                'slug' => $c->slug, 'label' => $c->name, 'sub' => $c->description, 'featured' => $c->featured,
            ])->all();

            $data['stack'] = $categories->flatMap(fn ($c) => $c->items->map(function ($item) use ($c) {
                $tech = [
                    'name' => $item->name,
                    'type' => $item->type,
                    'category' => $c->slug,
                    'svg' => $item->iconUrl()
                        ? '<img src="'.e($item->iconUrl()).'" width="36" height="36" alt="'.e($item->name).'" loading="lazy">'
                        : '',
                ];
                if ($item->level === 'estudio') {
                    $tech['level'] = 'estudio';
                }

                return $tech;
            }))->values()->all();
        }

        if (Project::exists()) {
            $data['projects'] = Project::visible()->ordered()->get()->map(fn (Project $p) => [
                'title' => $p->title,
                'company' => $p->company,
                'url' => $p->url,
                'github' => $p->github,
                'image_url' => $p->imageUrl(),
                'tags' => $p->tags ?? [],
                'desc' => $p->description,
                'links' => $p->links ?? [],
            ])->all();
        }

        if (Certificate::exists()) {
            $data['certs'] = Certificate::visible()->ordered()->get()->map(fn (Certificate $c) => [
                'title' => $c->title,
                'platform' => $c->platform,
                'year' => $c->year,
                'pdf_url' => $c->pdfUrl(),
                'preview_url' => $c->previewUrl(),
                'category' => $c->category,
            ])->all();
        }

        $data['gallery'] = self::gallery('develop');

        return $data;
    }
}

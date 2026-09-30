<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Project;
use App\Models\Setting;
use App\Models\StackCategory;
use App\Models\StackItem;

/** Copia a la base de datos el contenido inicial que vive en config/portfolio.php. */
class DefaultContentImporter
{
    public function import(bool $force = false): array
    {
        $portfolio = config('portfolio');
        $done = [];

        foreach (['github', 'linkedin', 'stats', 'available'] as $key) {
            if ($force || ! Setting::whereKey($key)->exists()) {
                Setting::updateOrCreate(['key' => $key], ['value' => $portfolio[$key]]);
            }
        }

        if ($force || ! StackCategory::exists()) {
            $force && StackCategory::query()->delete();
            $position = 0;
            $ids = [];
            foreach ($portfolio['stack_categories'] as $category) {
                $ids[$category['slug']] = StackCategory::create([
                    'slug' => $category['slug'], 'name' => $category['label'], 'description' => $category['sub'],
                    'featured' => $category['featured'], 'position' => ++$position,
                ])->id;
            }
            foreach ($portfolio['stack'] as $i => $tech) {
                preg_match('/src="([^"]+)"/', $tech['svg'], $m);
                StackItem::create([
                    'stack_category_id' => $ids[$tech['category']] ?? $ids['backend'],
                    'name' => $tech['name'], 'type' => $tech['type'] ?? null,
                    'level' => isset($tech['level']) ? 'estudio' : 'dominio',
                    'icon' => $m[1] ?? null, 'position' => $i + 1,
                ]);
            }
            $done[] = 'stack';
        }

        if ($force || ! Project::exists()) {
            $force && Project::query()->delete();
            foreach ($portfolio['projects'] as $i => $p) {
                Project::create([
                    'title' => $p['title'], 'company' => $p['company'], 'url' => $p['url'], 'github' => $p['github'],
                    'image' => file_exists(public_path('images/'.$p['image'])) ? $p['image'] : null,
                    'tags' => $p['tags'], 'description' => $p['desc'], 'links' => $p['links'], 'position' => $i + 1,
                ]);
            }
            $done[] = 'projects';
        }

        if ($force || ! Certificate::exists()) {
            $force && Certificate::query()->delete();
            foreach ($portfolio['certs'] as $i => $c) {
                Certificate::create([
                    'title' => $c['title'], 'platform' => $c['platform'], 'year' => $c['year'],
                    'pdf' => $c['pdf'], 'preview' => $c['preview'] ?? null, 'category' => $c['category'], 'position' => $i + 1,
                ]);
            }
            $done[] = 'certificates';
        }

        PortfolioContent::flush();

        return $done;
    }
}

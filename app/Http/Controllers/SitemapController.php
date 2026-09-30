<?php

namespace App\Http\Controllers;

use App\Models\Post;

class SitemapController extends Controller
{
    public function robots()
    {
        $lines = [
            'User-agent: *', 'Disallow: /login', 'Disallow: /admin', 'Disallow: /admin-dcc', 'Disallow: /admin-develop', '',
            'Sitemap: '.route('sitemap'),
        ];

        return response(implode("\n", $lines)."\n", 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    public function __invoke()
    {
        $urls = collect([
            route('portfolio'), route('proyectos'), route('stack'), route('experiencia'),
            route('contact.view'), route('blog.index'), route('dcc.index'), route('dcc.blog'), route('dcc.contacto'),
        ])->map(fn ($url) => ['loc' => $url]);

        $posts = Post::published()->get(['slug', 'category', 'updated_at', 'published_at'])
            ->map(fn (Post $p) => ['loc' => $p->publicUrl(), 'lastmod' => $p->updated_at->toIso8601String()]);

        $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($urls->concat($posts) as $u) {
            $xml .= '<url><loc>'.e($u['loc']).'</loc>'.(isset($u['lastmod']) ? '<lastmod>'.$u['lastmod'].'</lastmod>' : '').'</url>';
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}

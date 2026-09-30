<?php

namespace App\Http\Controllers\Admin;

use App\Models\CalendarEvent;
use App\Models\Certificate;
use App\Models\MediaItem;
use App\Models\Message;
use App\Models\Post;
use App\Models\Project;
use App\Models\StackItem;

class AreaController extends AdminController
{
    public function index()
    {
        $area = $this->area();
        $posts = Post::forArea($area);

        $cards = [
            'Blogs publicados' => (clone $posts)->where('published', true)->count(),
            'Borradores' => (clone $posts)->where('published', false)->count(),
            'Visualizaciones' => number_format((clone $posts)->sum('views')),
            'Me gusta' => number_format((clone $posts)->sum('likes')),
            'Imágenes' => MediaItem::where('scope', $area)->count(),
        ];

        if ($area === 'dcc') {
            $cards['Próximos eventos'] = CalendarEvent::upcoming()->count();
        } else {
            $cards += [
                'Mensajes sin leer' => Message::unread()->count(),
                'Tecnologías' => StackItem::count(),
                'Proyectos' => Project::count(),
                'Certificados' => Certificate::count(),
            ];
        }

        return $this->view('admin.area', [
            'cards' => $cards,
            'topPosts' => Post::forArea($area)->orderByDesc('views')->limit(5)->get(),
        ]);
    }
}

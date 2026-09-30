<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use App\Models\Post;
use App\Services\PortfolioContent;
use App\Services\PostEngagement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DccController extends Controller
{
    public function __construct(private PostEngagement $engagement) {}

    public function index()
    {
        return view('dcc.home', [
            'events' => CalendarEvent::visible()->upcoming()->limit(8)->get(),
            'calendar' => CalendarEvent::visible()->whereDate('starts_on', '>=', now()->startOfMonth()->subMonths(1))->whereDate('starts_on', '<=', now()->addMonths(6))->get(['title', 'type', 'starts_on', 'ends_on']),
            'gallery' => PortfolioContent::gallery('dcc'),
            'recentPosts' => Post::published()->forArea('dcc')->limit(3)->get(),
        ]);
    }

    public function blog(Request $request)
    {
        $query = Post::published()->forArea('dcc');

        if ($request->filled('cat') && in_array($request->cat, ['dcc-evento', 'dcc-informativo'], true)) {
            $query->where('category', $request->cat);
        }

        $posts = $query->paginate(6)->withQueryString();

        return view('dcc.blog', compact('posts'));
    }

    public function blogShow(Request $request, string $slug)
    {
        $post = Post::where('slug', $slug)->where('published', true)->forArea('dcc')->firstOrFail();
        $this->engagement->registerView($post, $request);

        $related = Post::published()->forArea('dcc')->where('id', '!=', $post->id)->limit(3)->get();
        $liked = $this->engagement->liked($post, $request);
        $likeUrl = route('dcc.blog.like', $post->slug);

        return view('dcc.blog-show', compact('post', 'related', 'liked', 'likeUrl'));
    }

    public function like(Request $request, string $slug): JsonResponse
    {
        $post = Post::where('slug', $slug)->where('published', true)->forArea('dcc')->firstOrFail();

        return $this->engagement->toggleLike($post, $request);
    }

    public function contacto()
    {
        return view('dcc.contacto');
    }
}

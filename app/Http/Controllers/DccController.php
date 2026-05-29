<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class DccController extends Controller
{
    public function index()
    {
        return view('dcc.home');
    }

    public function blog(Request $request)
    {
        $query = Post::published()
            ->whereIn('category', ['dcc-evento', 'dcc-informativo']);

        if ($request->filled('cat') && in_array($request->cat, ['dcc-evento', 'dcc-informativo'])) {
            $query->where('category', $request->cat);
        }

        $posts = $query->paginate(6)->withQueryString();

        return view('dcc.blog', compact('posts'));
    }

    public function blogShow(string $slug)
    {
        $post    = Post::where('slug', $slug)->where('published', true)->firstOrFail();
        $related = Post::published()
            ->whereIn('category', ['dcc-evento', 'dcc-informativo'])
            ->where('id', '!=', $post->id)
            ->limit(3)->get();
        return view('dcc.blog-show', compact('post', 'related'));
    }

    public function contacto()
    {
        return view('dcc.contacto');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts    = Post::published()->paginate(6);
        $portfolio = config('portfolio');
        return view('blog.index', compact('posts', 'portfolio'));
    }

    public function show(string $slug)
    {
        $post      = Post::where('slug', $slug)->where('published', true)->firstOrFail();
        $related   = Post::published()->where('id', '!=', $post->id)->limit(3)->get();
        $portfolio = config('portfolio');
        return view('blog.show', compact('post', 'related', 'portfolio'));
    }
}
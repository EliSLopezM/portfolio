<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PortfolioContent;
use App\Services\PostEngagement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct(private PostEngagement $engagement) {}

    public function index()
    {
        $posts = Post::published()->forArea('develop')->paginate(6);
        $portfolio = PortfolioContent::get();

        return view('blog.index', compact('posts', 'portfolio'));
    }

    public function show(Request $request, string $slug)
    {
        $post = Post::where('slug', $slug)->where('published', true)->forArea('develop')->firstOrFail();
        $this->engagement->registerView($post, $request);

        $related = Post::published()->forArea('develop')->where('id', '!=', $post->id)->limit(3)->get();
        $portfolio = PortfolioContent::get();
        $liked = $this->engagement->liked($post, $request);
        $likeUrl = route('blog.like', $post->slug);

        return view('blog.show', compact('post', 'related', 'portfolio', 'liked', 'likeUrl'));
    }

    public function like(Request $request, string $slug): JsonResponse
    {
        $post = Post::where('slug', $slug)->where('published', true)->forArea('develop')->firstOrFail();

        return $this->engagement->toggleLike($post, $request);
    }
}

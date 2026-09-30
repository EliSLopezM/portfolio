<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/** Vistas y «me gusta» de los blogs, sin tocar updated_at. */
class PostEngagement
{
    private const BOTS = '/bot|crawl|spider|slurp|preview|facebookexternalhit|whatsapp|curl|wget|python-requests|headless/i';

    public const LIKE_COOKIE = 'liked_posts';

    /** Cuenta una visita por visitante y artículo cada 24 h; ignora bots y al administrador. */
    public function registerView(Post $post, Request $request): void
    {
        if ($request->user()?->is_admin || preg_match(self::BOTS, (string) $request->userAgent()) || $request->headers->get('Purpose') === 'prefetch') {
            return;
        }

        $visitor = hash('sha256', $request->ip().'|'.$request->userAgent());

        if (Cache::add("post-view:{$post->id}:{$visitor}", 1, now()->addDay())) {
            DB::table('posts')->where('id', $post->id)->increment('views');
            $post->views++;
        }
    }

    public function liked(Post $post, Request $request): bool
    {
        return in_array($post->id, $this->likedIds($request), true);
    }

    /** Alterna el «me gusta» de este visitante (recordado en una cookie de 1 año). */
    public function toggleLike(Post $post, Request $request): JsonResponse
    {
        $ids = $this->likedIds($request);
        $liked = ! in_array($post->id, $ids, true);

        if ($liked) {
            DB::table('posts')->where('id', $post->id)->increment('likes');
            $ids[] = $post->id;
        } else {
            DB::table('posts')->where('id', $post->id)->where('likes', '>', 0)->decrement('likes');
            $ids = array_values(array_diff($ids, [$post->id]));
        }

        return response()
            ->json(['liked' => $liked, 'likes' => (int) DB::table('posts')->where('id', $post->id)->value('likes')])
            ->cookie(cookie(self::LIKE_COOKIE, json_encode(array_slice($ids, -200)), 60 * 24 * 365, '/', null, $request->isSecure(), true, false, 'lax'));
    }

    /** @return int[] */
    private function likedIds(Request $request): array
    {
        $ids = json_decode((string) $request->cookie(self::LIKE_COOKIE), true);

        return is_array($ids) ? array_map('intval', $ids) : [];
    }
}

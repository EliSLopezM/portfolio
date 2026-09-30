{{-- Metadatos SEO generados automáticamente desde los datos del blog. --}}
<meta property="article:published_time" content="{{ $post->published_at?->toIso8601String() }}">
<meta property="article:modified_time" content="{{ $post->updated_at?->toIso8601String() }}">
<meta property="article:author" content="{{ $post->author }}">
<meta property="article:section" content="{{ $post->category }}">
@foreach(array_filter(array_map('trim', explode(',', $post->seoKeywords()))) as $tag)<meta property="article:tag" content="{{ $tag }}">@endforeach
<script type="application/ld+json">{!! json_encode($post->jsonLd(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>

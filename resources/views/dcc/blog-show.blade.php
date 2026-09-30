@extends('dcc.layout')
@section('title', $post->seoTitle() . ' — DCC Bosa Villa Suaita')
@section('description', $post->seoDescription())
@section('keywords', $post->seoKeywords())
@section('canonical', $post->publicUrl())
@section('og_type', 'article')
@section('og_image', $post->coverUrl() ?: asset('images/elilogo.png'))
@push('head')
    @include('partials.post-seo', ['post' => $post])
    <link rel="stylesheet" href="{{ asset('css/engage.css') }}">
@endpush
@push('scripts')<script src="{{ asset('js/engage.js') }}" defer></script>@endpush
@section('content')
<section class="dcc-section dcc-section-light" style="padding-top:120px">
    <div class="container" style="max-width:800px">
        <a href="{{ route('dcc.blog') }}" class="dcc-back-link">← Volver al blog</a>
        <span class="dcc-post-cat" style="display:inline-block;margin:16px 0 8px">
            {{ $post->category === 'dcc-evento' ? 'Evento' : 'Informativo' }}
        </span>
        <h1 class="dcc-post-title">{{ $post->title }}</h1>
        <div class="dcc-post-meta">{{ $post->published_at?->format('d \d\e F \d\e Y') }} · {{ $post->author }} · {{ $post->readingMinutes() }} min · {{ number_format($post->views) }} vistas</div>
        @if($post->coverUrl())
        <img src="{{ $post->coverUrl() }}" alt="{{ $post->title }}"
            style="width:100%;border-radius:16px;margin:24px 0;object-fit:cover;max-height:400px">
        @endif
        <div class="dcc-post-content">{{ $post->renderedContent() }}</div>
        @include('partials.post-video', ['post' => $post])
        @include('partials.post-engage', ['post' => $post, 'liked' => $liked, 'likeUrl' => $likeUrl])
        @if($related->count())
        <div style="margin-top:60px;border-top:1px solid rgba(232,112,10,0.2);padding-top:40px">
            <h3 style="margin-bottom:24px">Más publicaciones</h3>
            <div class="dcc-posts-grid">
                @foreach($related as $r)
                <a href="{{ route('dcc.blog.show', $r->slug) }}" class="dcc-post-card">
                    <div class="dcc-post-body">
                        <span class="dcc-post-cat">{{ $r->category === 'dcc-evento' ? 'Evento' : 'Informativo' }}</span>
                        <h3>{{ $r->title }}</h3>
                        <p>{{ $r->excerpt }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
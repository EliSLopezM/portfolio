@extends('layouts.app')
@section('title', $post->seoTitle() . ' — Blog Eli Santiago López')
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
<section class="page-section">
    <div class="container">

        <div class="blog-post-header">
            <a href="{{ route('blog.index') }}" class="back-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                Volver al blog
            </a>
            <div class="blog-post-meta">
                <span class="tag">{{ $post->category }}</span>
                <span class="blog-date">{{ $post->published_at->format('d M Y') }}</span>
                <span class="blog-date">· {{ $post->author }} · {{ $post->readingMinutes() }} min · {{ number_format($post->views) }} vistas</span>
            </div>
            <h1 class="blog-post-title">{{ $post->title }}</h1>
            <p class="blog-post-excerpt">{{ $post->excerpt }}</p>
        </div>

        @if($post->cover_image)
        <div class="blog-post-cover">
            <img src="{{ $post->coverUrl() }}" alt="{{ $post->title }}" width="1200" height="630">
        </div>
        @endif

        <div class="blog-post-content">
            {{ $post->renderedContent() }}
        </div>

        @include('partials.post-video', ['post' => $post])

        @include('partials.post-engage', ['post' => $post, 'liked' => $liked, 'likeUrl' => $likeUrl])

        {{-- ARTÍCULOS RELACIONADOS ── --}}
        @if($related->count())
        <div class="blog-related">
            <h3 class="blog-related-title">Artículos relacionados</h3>
            <div class="blog-related-grid">
                @foreach($related as $r)
                <a href="{{ route('blog.show', $r->slug) }}" class="blog-related-card">
                    <span class="tag tag-sm">{{ $r->category }}</span>
                    <p class="blog-related-name">{{ $r->title }}</p>
                    <span class="blog-related-date">{{ $r->published_at->format('d M Y') }}</span>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>
@endsection
{{-- Me gusta, vistas y botones para compartir/promocionar el blog. --}}
@php
  $url = $post->publicUrl();
  $text = $post->title;
  $networks = [
    'LinkedIn' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($url),
    'Facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($url),
    'X'        => 'https://twitter.com/intent/tweet?url=' . urlencode($url) . '&text=' . urlencode($text),
    'WhatsApp' => 'https://wa.me/?text=' . urlencode($text . ' ' . $url),
    'Telegram' => 'https://t.me/share/url?url=' . urlencode($url) . '&text=' . urlencode($text),
  ];
@endphp
<div class="post-engage" data-like-url="{{ $likeUrl }}" data-title="{{ $post->title }}" data-url="{{ $url }}" data-excerpt="{{ $post->seoDescription() }}">
  <div class="post-engage-stats">
    <button type="button" class="pe-like {{ $liked ? 'is-liked' : '' }}" aria-pressed="{{ $liked ? 'true' : 'false' }}" aria-label="Me gusta">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 21s-7.5-4.6-9.6-9.3C.9 8.3 3 4.5 6.6 4.5c2 0 3.6 1.1 4.4 2.6h2c.8-1.5 2.4-2.6 4.4-2.6 3.6 0 5.7 3.8 4.2 7.2C19.5 16.4 12 21 12 21z"/></svg>
      <span class="pe-like-count">{{ number_format($post->likes) }}</span> <span class="pe-like-label">Me gusta</span>
    </button>
    <span class="pe-views">👁 {{ number_format($post->views) }} vistas</span>
  </div>
  <p class="pe-title">Comparte este artículo</p>
  <div class="pe-links">
    @foreach($networks as $name => $href)
      <a href="{{ $href }}" target="_blank" rel="noopener noreferrer" class="pe-btn">{{ $name }}</a>
    @endforeach
    <button type="button" class="pe-btn pe-native" hidden>Compartir…</button>
    <button type="button" class="pe-btn pe-copy" data-copy="{{ $url }}">Copiar enlace</button>
  </div>
</div>

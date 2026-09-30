@if($post->videoEmbedUrl())
<div class="post-video"><iframe src="{{ $post->videoEmbedUrl() }}" title="Video: {{ $post->title }}" loading="lazy" allow="accelerometer; encrypted-media; picture-in-picture; fullscreen" allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe></div>
@endif

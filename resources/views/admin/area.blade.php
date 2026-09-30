@extends('admin.layout')
@section('title', 'Resumen')
@section('content')
<div class="head">
  <div><h1>Resumen {{ $area === 'dcc' ? 'DCC' : 'Develop' }}</h1><p class="muted">Estado general del sitio.</p></div>
  <a class="btn" href="{{ route("admin.$area.posts.create") }}">+ Nuevo blog</a>
</div>
<div class="grid" style="margin-bottom:1.5rem">
  @foreach($cards as $label => $value)<div class="stat"><b>{{ $value }}</b><span>{{ $label }}</span></div>@endforeach
</div>
<div class="card">
  <h2>Blogs más vistos</h2>
  @forelse($topPosts as $p)
    <p style="padding:.45rem 0;border-bottom:1px solid var(--border)">
      <a href="{{ route("admin.$area.posts.edit", $p) }}">{{ $p->title }}</a>
      <span class="muted mono" style="float:right">{{ number_format($p->views) }} vistas · {{ number_format($p->likes) }} ♥</span>
    </p>
  @empty <p class="muted">Aún no hay blogs.</p> @endforelse
</div>
@endsection

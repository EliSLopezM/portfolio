@extends('admin.layout')
@section('title', 'Imágenes')
@section('content')
<div class="head"><div><h1>Imágenes {{ $area === 'dcc' ? 'DCC' : 'Develop' }}</h1>
  <p class="muted">{{ $area === 'dcc' ? 'Se muestran en la galería de la página DCC.' : 'Galería del portafolio.' }} Arrastra para ordenar; oculta las que no quieras mostrar.</p></div></div>

<form class="card" method="POST" action="{{ route("admin.$area.media.store") }}" enctype="multipart/form-data">@csrf
  <h2>Subir imágenes</h2>
  <div class="row">
    <div class="field"><label for="images">Archivos (JPG, PNG, WEBP, GIF · máx. 5 MB)</label><input type="file" id="images" name="images[]" accept="image/jpeg,image/png,image/webp,image/gif" multiple required></div>
    <div class="field"><label for="title">Título (opcional)</label><input type="text" id="title" name="title" maxlength="120"></div>
    <div class="field"><label for="alt">Texto alternativo</label><input type="text" id="alt" name="alt" maxlength="160"></div>
  </div>
  <button class="btn" type="submit">Subir</button>
</form>

@if($items->isEmpty()) <p class="muted">Aún no hay imágenes.</p> @endif
<div class="media-grid" data-sortable="{{ route("admin.$area.reorder", 'media') }}">
  @foreach($items as $m)
  <div class="card {{ $m->visible ? '' : 'hidden-item' }}" data-id="{{ $m->id }}" draggable="true">
    <img src="{{ $m->url() }}" alt="{{ $m->alt ?: $m->title }}" loading="lazy" draggable="false">
    <form method="POST" action="{{ route("admin.$area.media.update", $m) }}" enctype="multipart/form-data">@csrf @method('PUT')
      <div class="field"><input type="text" name="title" value="{{ $m->title }}" placeholder="Título" maxlength="120" aria-label="Título"></div>
      <div class="field"><input type="text" name="alt" value="{{ $m->alt }}" placeholder="Texto alternativo" maxlength="160" aria-label="Texto alternativo"></div>
      <div class="field"><input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif" aria-label="Reemplazar imagen"></div>
      <button class="btn sm" type="submit">Guardar</button>
    </form>
    <div style="margin-top:.6rem;display:flex;justify-content:space-between;gap:.5rem;flex-wrap:wrap">
      @include('admin.partials.actions', ['resource' => 'media', 'item' => $m, 'destroy' => route("admin.$area.media.destroy", $m), 'confirm' => '¿Eliminar esta imagen?'])
      @include('admin.partials.move')
    </div>
  </div>
  @endforeach
</div>
@endsection

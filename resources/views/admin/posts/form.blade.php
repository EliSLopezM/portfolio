@extends('admin.layout')
@section('title', $post->exists ? 'Editar blog' : 'Nuevo blog')
@section('content')
@php $action = $post->exists ? route("admin.$area.posts.update", $post) : route("admin.$area.posts.store"); @endphp
<div class="head">
  <div><h1>{{ $post->exists ? 'Editar blog' : 'Nuevo blog' }}</h1>
    <p class="muted">Autor: <strong>{{ $post->author }}</strong> · <span id="readTime"></span>
    @if($post->exists) · {{ number_format($post->views) }} vistas · {{ number_format($post->likes) }} ♥ @endif</p></div>
  <div class="actions-bar">
    @if($post->exists && $post->published)
      <a class="btn ghost" href="{{ $post->publicUrl() }}" target="_blank" rel="noopener">Ver publicado ↗</a>
      <button class="btn ghost" type="button" data-copy="{{ $post->publicUrl() }}">Copiar link</button>
    @endif
    <a class="btn ghost" href="{{ route("admin.$area.posts.index") }}">← Volver</a>
  </div>
</div>

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" data-seo-url="{{ route("admin.$area.posts.seo") }}">
  @csrf @if($post->exists) @method('PUT') @endif
  <div class="cols">
    <div>
      <div class="card">
        <div class="field"><label for="title">Título</label><input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" maxlength="150" required></div>
        <div class="field"><label for="excerpt">Resumen (aparece en listados y redes)</label><textarea id="excerpt" name="excerpt" maxlength="300" required style="min-height:70px">{{ old('excerpt', $post->excerpt) }}</textarea></div>

        <label>Contenido</label>
        <div class="editor-toolbar" role="toolbar" aria-label="Formato">
          <button type="button" data-cmd="h2">H2</button><button type="button" data-cmd="h3">H3</button><button type="button" data-cmd="p">Párrafo</button>
          <button type="button" data-cmd="bold"><b>B</b></button><button type="button" data-cmd="italic"><i>I</i></button>
          <button type="button" data-cmd="ul">• Lista</button><button type="button" data-cmd="ol">1. Lista</button><button type="button" data-cmd="quote">“ Cita</button>
          <button type="button" data-cmd="link">Enlace</button><button type="button" data-cmd="image">🖼 Imagen</button><button type="button" data-cmd="table">▦ Tabla</button><button type="button" data-cmd="clear">Limpiar</button>
          <label for="imgSize" class="sr-only" style="margin:0 0 0 .5rem">Tamaño de imagen</label>
          <select id="imgSize" title="Tamaño de la imagen seleccionada (haz clic en una imagen del texto para cambiarla)" style="width:auto;padding:.3rem .5rem;font-size:.8rem">
            <option value="400">Imagen pequeña · 400 px</option><option value="700" selected>Mediana · 700 px</option><option value="1000">Grande · 1000 px</option><option value="">Ancho completo</option>
          </select>
        </div>
        <div id="editorArea" class="editor-area" contenteditable="true" role="textbox" aria-multiline="true" aria-label="Contenido del blog"></div>
        <textarea id="contentField" name="content" hidden>{{ old('content', $post->getRawOriginal('content') ? (string) $post->renderedContent() : '') }}</textarea>
        <input type="file" id="inlineImage" hidden accept="image/jpeg,image/png,image/webp,image/gif" data-url="{{ route("admin.$area.posts.image") }}">
        <p class="hint">Imágenes del texto: se reducen a máx. {{ config('images.presets.blog_inline.w') }} px de ancho al subir. Haz clic en una imagen y cambia «Tamaño» para achicarla o ampliarla. El contenido se sanitiza al guardar: solo se conservan títulos, listas, enlaces, imágenes y tablas.</p>
      </div>

      <div class="card">
        <h2>Video (opcional)</h2>
        <div class="field"><label for="video_url">Enlace de YouTube o Vimeo</label><input type="url" id="video_url" name="video_url" value="{{ old('video_url', $post->video_url) }}" placeholder="https://www.youtube.com/watch?v=…" maxlength="255">
          <p class="hint">Se muestra incrustado al final del artículo. Sube el video a YouTube/Vimeo (puede ser «no listado») y pega el enlace.</p></div>
      </div>
      </div>

      <div class="card">
        <h2>SEO</h2>
        <p class="muted" style="margin-bottom:1rem">Se genera automáticamente con el título, resumen y contenido del blog. Escribe aquí solo si quieres sobrescribirlo.</p>
        <div class="field"><label for="meta_title">Título SEO <span class="counter" id="meta_titleCount"></span></label><input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}" maxlength="70" placeholder="{{ $post->exists ? $post->seoTitle() : '' }}"></div>
        <div class="field"><label for="meta_description">Descripción SEO <span class="counter" id="meta_descriptionCount"></span></label><textarea id="meta_description" name="meta_description" maxlength="170" style="min-height:70px" placeholder="{{ $post->exists ? $post->seoDescription() : '' }}">{{ old('meta_description', $post->meta_description) }}</textarea></div>
        <div class="field"><label for="keywords">Palabras clave</label><input type="text" id="keywords" name="keywords" value="{{ old('keywords', $post->keywords) }}" maxlength="255" placeholder="{{ $post->exists ? $post->seoKeywords() : '' }}"></div>
        <div class="seo-preview" aria-label="Vista previa en Google"><div class="u">{{ parse_url(config('app.url'), PHP_URL_HOST) }} › blog</div><div class="t" id="pvTitle"></div><div class="d" id="pvDesc"></div></div>
        <button type="button" class="btn ghost sm" id="applySeo" style="margin-top:.75rem">Fijar valores sugeridos</button>
      </div>
    </div>

    <aside>
      <div class="card">
        <h2>Publicación</h2>
        <div class="field"><label class="check"><input type="checkbox" name="published" value="1" @checked(old('published', $post->published))> Publicado</label></div>
        <div class="field"><label for="published_at">Fecha de publicación</label><input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"><p class="hint">Vacía = ahora, al publicar.</p></div>
        <div class="field"><label for="category">Categoría</label><select id="category" name="category">@foreach($categories as $k => $l)<option value="{{ $k }}" @selected(old('category', $post->category) === $k)>{{ $l }}</option>@endforeach</select></div>
        <div class="field"><label for="slug">URL (slug)</label><input type="text" id="slug" name="slug" value="{{ old('slug', $post->slug) }}" maxlength="160" pattern="[a-z0-9]+(-[a-z0-9]+)*" placeholder="se-genera-del-titulo"><p class="hint">Cambiarla rompe enlaces ya compartidos.</p></div>
        <button class="btn" type="submit" style="width:100%;justify-content:center">Guardar blog</button>
      </div>
      <div class="card">
        <h2>Portada</h2>
        @if($post->coverUrl())<img src="{{ $post->coverUrl() }}" alt="Portada actual" style="width:100%;border-radius:6px;margin-bottom:.6rem">
          <label class="check" style="margin-bottom:.6rem"><input type="checkbox" name="remove_cover" value="1"> Quitar portada</label>@endif
        @include('admin.partials.img-input', ['name' => 'cover', 'preset' => 'blog_cover'])
      </div>
    </aside>
  </div>
</form>
@endsection

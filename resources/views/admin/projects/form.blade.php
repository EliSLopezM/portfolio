@extends('admin.layout')
@section('title', $project->exists ? 'Editar proyecto' : 'Nuevo proyecto')
@section('content')
<div class="head"><h1>{{ $project->exists ? 'Editar proyecto' : 'Nuevo proyecto' }}</h1><a class="btn ghost" href="{{ route("admin.$area.projects.index") }}">← Volver</a></div>
<form class="card" method="POST" enctype="multipart/form-data" action="{{ $project->exists ? route("admin.$area.projects.update", $project) : route("admin.$area.projects.store") }}">
  @csrf @if($project->exists) @method('PUT') @endif
  <div class="row">
    <div class="field"><label for="title">Título</label><input type="text" id="title" name="title" value="{{ old('title', $project->title) }}" maxlength="150" required></div>
    <div class="field"><label for="company">Empresa / cliente</label><input type="text" id="company" name="company" value="{{ old('company', $project->company) }}" maxlength="150"></div>
  </div>
  <div class="row">
    <div class="field"><label for="url">Sitio web (https)</label><input type="url" id="url" name="url" value="{{ old('url', $project->url) }}" maxlength="255"></div>
    <div class="field"><label for="github">GitHub (https)</label><input type="url" id="github" name="github" value="{{ old('github', $project->github) }}" maxlength="255"></div>
  </div>
  <div class="field"><label for="description">Descripción</label><textarea id="description" name="description" maxlength="1500" required>{{ old('description', $project->description) }}</textarea></div>
  <div class="field"><label for="tags">Tecnologías (separadas por coma)</label><input type="text" id="tags" name="tags" value="{{ old('tags', implode(', ', $project->tags ?? [])) }}" maxlength="300" placeholder="Laravel, MySQL, Docker"></div>
  <div class="field"><label for="links">Enlaces (uno por línea)</label>
    <textarea id="links" name="links" maxlength="1000" placeholder="timiweb.com | https://timiweb.com | destacado&#10;Play Store | https://play.google.com/…">{{ old('links', collect($project->links ?? [])->map(fn ($l) => $l['label'] . ' | ' . $l['url'] . ($l['featured'] ? ' | destacado' : ''))->implode("\n")) }}</textarea>
    <p class="hint">Formato: Etiqueta | https://url | destacado (opcional: el enlace «destacado» aparece sobre la imagen).</p></div>
  <div class="field"><label for="image">Imagen</label>
    @if($project->imageUrl())<img src="{{ $project->imageUrl() }}" alt="" style="max-width:260px;border-radius:6px;display:block;margin-bottom:.5rem"><label class="check"><input type="checkbox" name="remove_image" value="1"> Quitar imagen</label>@endif
    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp,image/gif"></div>
  <button class="btn" type="submit">Guardar</button>
</form>
@endsection

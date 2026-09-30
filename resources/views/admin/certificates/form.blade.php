@extends('admin.layout')
@section('title', $certificate->exists ? 'Editar certificado' : 'Nuevo certificado')
@section('content')
<div class="head"><h1>{{ $certificate->exists ? 'Editar certificado' : 'Nuevo certificado' }}</h1><a class="btn ghost" href="{{ route("admin.$area.certificates.index") }}">← Volver</a></div>
<form class="card" method="POST" enctype="multipart/form-data" action="{{ $certificate->exists ? route("admin.$area.certificates.update", $certificate) : route("admin.$area.certificates.store") }}">
  @csrf @if($certificate->exists) @method('PUT') @endif
  <div class="field"><label for="title">Título</label><input type="text" id="title" name="title" value="{{ old('title', $certificate->title) }}" maxlength="150" required></div>
  <div class="row">
    <div class="field"><label for="platform">Institución / plataforma</label><input type="text" id="platform" name="platform" value="{{ old('platform', $certificate->platform) }}" maxlength="100" required></div>
    <div class="field"><label for="year">Año</label><input type="number" id="year" name="year" value="{{ old('year', $certificate->year) }}" min="1990" max="2100" required></div>
    <div class="field"><label for="category">Categoría</label><select id="category" name="category">@foreach(\App\Models\Certificate::CATEGORIES as $k => $l)<option value="{{ $k }}" @selected(old('category', $certificate->category) === $k)>{{ $l }}</option>@endforeach</select></div>
  </div>
  <div class="row">
    <div class="field"><label for="pdf">PDF del certificado (máx. 10 MB)</label>@if($certificate->pdfUrl())<p class="hint"><a href="{{ $certificate->pdfUrl() }}" target="_blank" rel="noopener">Ver PDF actual</a></p>@endif<input type="file" id="pdf" name="pdf" accept="application/pdf"></div>
    <div class="field"><label for="preview">Imagen de vista previa</label>@if($certificate->previewUrl())<img src="{{ $certificate->previewUrl() }}" alt="" style="max-width:180px;border-radius:6px;display:block;margin-bottom:.4rem">@endif@include('admin.partials.img-input', ['name' => 'preview', 'preset' => 'certificate', 'id' => 'preview'])</div>
  </div>
  <button class="btn" type="submit">Guardar</button>
</form>
@endsection

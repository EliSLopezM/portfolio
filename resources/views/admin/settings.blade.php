@extends('admin.layout')
@section('title', 'Enlaces y cifras')
@section('content')
<div class="head"><div><h1>Enlaces y cifras</h1><p class="muted">Lo que se muestra en el encabezado y en los contadores del portafolio.</p></div></div>
<form class="card" method="POST" action="{{ route("admin.$area.settings.update") }}">@csrf @method('PUT')
  <h2>Redes</h2>
  <div class="row">
    <div class="field"><label for="github">GitHub</label><input type="url" id="github" name="github" value="{{ old('github', $github) }}" required maxlength="255"></div>
    <div class="field"><label for="linkedin">LinkedIn</label><input type="url" id="linkedin" name="linkedin" value="{{ old('linkedin', $linkedin) }}" required maxlength="255"></div>
  </div>
  <div class="field"><label class="check"><input type="checkbox" name="available" value="1" @checked(old('available', $available))> Disponible para nuevos proyectos</label></div>

  <h2 style="margin-top:1.5rem">Cifras destacadas</h2>
  <p class="muted" style="margin-bottom:1rem">Ej.: «3+» años de experiencia, «6» proyectos en producción, «2» apps publicadas.</p>
  @foreach(old('stats', $stats) as $i => $stat)
  <div class="row">
    <div class="field"><label for="sv{{ $i }}">Valor {{ $i + 1 }}</label><input type="text" id="sv{{ $i }}" name="stats[{{ $i }}][value]" value="{{ $stat['value'] }}" maxlength="12" required></div>
    <div class="field"><label for="sl{{ $i }}">Descripción</label><input type="text" id="sl{{ $i }}" name="stats[{{ $i }}][label]" value="{{ $stat['label'] }}" maxlength="60" required></div>
  </div>
  @endforeach
  <button class="btn" type="submit">Guardar</button>
</form>
@endsection

@extends('admin.layout')
@section('title', $event->exists ? 'Editar fecha' : 'Nueva fecha')
@section('content')
<div class="head"><h1>{{ $event->exists ? 'Editar fecha' : 'Nueva fecha' }}</h1><a class="btn ghost" href="{{ route("admin.$area.events.index") }}">← Volver</a></div>
<form class="card" method="POST" action="{{ $event->exists ? route("admin.$area.events.update", $event) : route("admin.$area.events.store") }}">
  @csrf @if($event->exists) @method('PUT') @endif
  <div class="field"><label for="title">Título</label><input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" maxlength="150" required></div>
  <div class="row">
    <div class="field"><label for="type">Tipo</label><select id="type" name="type">@foreach(config('admin.event_types') as $k => $l)<option value="{{ $k }}" @selected(old('type', $event->type) === $k)>{{ $l }}</option>@endforeach</select></div>
    <div class="field"><label for="starts_on">Fecha</label><input type="date" id="starts_on" name="starts_on" value="{{ old('starts_on', $event->starts_on?->toDateString()) }}" required></div>
    <div class="field"><label for="ends_on">Hasta (opcional)</label><input type="date" id="ends_on" name="ends_on" value="{{ old('ends_on', $event->ends_on?->toDateString()) }}"></div>
    <div class="field"><label for="starts_at">Hora (opcional)</label><input type="time" id="starts_at" name="starts_at" value="{{ old('starts_at', $event->starts_at) }}"></div>
  </div>
  <div class="field"><label for="location">Lugar (opcional)</label><input type="text" id="location" name="location" value="{{ old('location', $event->location) }}" maxlength="150"></div>
  <div class="field"><label for="description">Descripción (opcional)</label><textarea id="description" name="description" maxlength="1000">{{ old('description', $event->description) }}</textarea></div>
  <div class="field"><label class="check"><input type="checkbox" name="visible" value="1" @checked(old('visible', $event->visible ?? true))> Visible en el sitio</label></div>
  <button class="btn" type="submit">Guardar</button>
</form>
@endsection

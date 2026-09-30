@extends('admin.layout')
@section('title', 'Mensajes')
@section('content')
@php $labels = config('admin.message_statuses'); @endphp
<div class="head"><div><h1>Mensajes de contacto</h1><p class="muted">Solo llegan aquí los mensajes que pasaron reCAPTCHA y las validaciones de seguridad.</p></div></div>

<div class="tabs">
  <a href="{{ route("admin.$area.messages.index") }}" class="{{ !request('estado') ? 'active' : '' }}">Todos</a>
  <a href="{{ route("admin.$area.messages.index", ['estado' => 'nuevo']) }}" class="{{ request('estado') === 'nuevo' ? 'active' : '' }}">Sin leer ({{ $counts['nuevo'] }})</a>
  @foreach($labels as $key => $label)
    <a href="{{ route("admin.$area.messages.index", ['estado' => $key]) }}" class="{{ request('estado') === $key ? 'active' : '' }}">{{ $label }} ({{ $counts[$key] }})</a>
  @endforeach
</div>

<form class="actions-bar" method="GET" style="margin-bottom:1rem">
  <input type="hidden" name="estado" value="{{ request('estado') }}">
  <input type="search" name="q" value="{{ request('q') }}" placeholder="Buscar nombre, correo o asunto…" style="max-width:320px" aria-label="Buscar">
  <button class="btn ghost" type="submit">Buscar</button>
</form>

<form method="POST" action="{{ route("admin.$area.messages.bulk") }}" id="bulkForm">@csrf
  <div class="bulk">
    <strong class="mono" style="font-size:.8rem">Con los seleccionados:</strong>
    <select name="action" aria-label="Acción">
      <option value="add">Agregar estado</option><option value="remove">Quitar estado</option><option value="set">Dejar solo el estado</option><option value="delete">Eliminar</option>
    </select>
    <select name="status" aria-label="Estado">@foreach($labels as $key => $label)<option value="{{ $key }}">{{ $label }}</option>@endforeach</select>
    <button class="btn sm" type="submit">Aplicar</button>
  </div>
  <div class="card table-wrap">
    <table>
      <thead><tr><th><input type="checkbox" data-select-all=".msg-check" aria-label="Seleccionar todos"></th><th>Fecha</th><th>Contacto</th><th>Asunto</th><th>Estados</th><th></th></tr></thead>
      <tbody>
      @forelse($messages as $m)
        <tr class="{{ $m->isUnread() ? 'unread' : '' }}">
          <td><input class="msg-check" type="checkbox" name="ids[]" value="{{ $m->id }}" aria-label="Seleccionar mensaje de {{ $m->nombre }}"></td>
          <td class="muted mono">{{ $m->created_at->format('d/m/Y H:i') }}</td>
          <td><a href="{{ route("admin.$area.messages.show", $m) }}">{{ $m->nombre }}</a><div class="muted">{{ $m->email }}</div></td>
          <td>{{ \Illuminate\Support\Str::limit($m->asunto ?: $m->mensaje, 60) }}</td>
          <td>@if($m->isUnread())<span class="pill on">Nuevo</span>@endif @foreach($m->statuses ?? [] as $s)<span class="pill st-{{ $s }}">{{ $labels[$s] ?? $s }}</span> @endforeach</td>
          <td><a class="btn ghost sm" href="{{ route("admin.$area.messages.show", $m) }}">Abrir</a></td>
        </tr>
      @empty
        <tr><td colspan="6" class="muted">No hay mensajes.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</form>
{{ $messages->links() }}
@endsection

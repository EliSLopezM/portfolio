@extends('admin.layout')
@section('title', 'Calendario')
@section('content')
<div class="head"><div><h1>Calendario DCC</h1><p class="muted">Días especiales, reuniones y actividades que se muestran en la página DCC.</p></div>
  <a class="btn" href="{{ route("admin.$area.events.create") }}">+ Agregar fecha</a></div>

@foreach(['Próximas' => $upcoming, 'Pasadas (últimas 20)' => $past] as $title => $list)
<div class="card"><h2>{{ $title }}</h2>
  @forelse($list as $e)
  <div style="display:flex;gap:1rem;align-items:center;justify-content:space-between;flex-wrap:wrap;padding:.6rem 0;border-bottom:1px solid var(--border)">
    <div>
      <strong>{{ $e->title }}</strong> <span class="pill">{{ config('admin.event_types')[$e->type] ?? $e->type }}</span>
      <div class="muted mono">{{ $e->starts_on->translatedFormat('d M Y') }}@if($e->ends_on) → {{ $e->ends_on->translatedFormat('d M Y') }}@endif @if($e->starts_at) · {{ $e->starts_at }}@endif @if($e->location) · {{ $e->location }}@endif</div>
    </div>
    @include('admin.partials.actions', ['resource' => 'events', 'item' => $e, 'edit' => route("admin.$area.events.edit", $e), 'destroy' => route("admin.$area.events.destroy", $e), 'confirm' => '¿Eliminar esta fecha?'])
  </div>
  @empty <p class="muted">Sin fechas.</p> @endforelse
</div>
@endforeach
@endsection

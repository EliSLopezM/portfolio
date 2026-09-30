@extends('admin.layout')
@section('title', 'Trabajo real')
@section('content')
<div class="head"><div><h1>Trabajo real, problemas reales</h1><p class="muted">Proyectos del portafolio. Arrastra para ordenar.</p></div><a class="btn" href="{{ route("admin.$area.projects.create") }}">+ Nuevo proyecto</a></div>
<ul class="sortable" data-sortable="{{ route("admin.$area.reorder", 'projects') }}">
@forelse($projects as $p)
  <li data-id="{{ $p->id }}" draggable="true" class="{{ $p->visible ? '' : 'hidden-item' }}">
    @include('admin.partials.move')
    @if($p->imageUrl())<img class="thumb" src="{{ $p->imageUrl() }}" alt="" loading="lazy" draggable="false">@endif
    <div class="grow"><strong>{{ $p->title }}</strong><div class="muted">{{ $p->company }} · {{ implode(', ', $p->tags ?? []) }}</div></div>
    @include('admin.partials.actions', ['resource' => 'projects', 'item' => $p, 'edit' => route("admin.$area.projects.edit", $p), 'destroy' => route("admin.$area.projects.destroy", $p), 'confirm' => "¿Eliminar «{$p->title}»?"])
  </li>
@empty <p class="muted">Sin proyectos.</p> @endforelse
</ul>
@endsection

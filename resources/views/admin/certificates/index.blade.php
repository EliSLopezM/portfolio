@extends('admin.layout')
@section('title', 'Certificados')
@section('content')
<div class="head"><div><h1>Certificados</h1><p class="muted">Arrastra para ordenar; los «Destacados» llevan estrella en el sitio.</p></div><a class="btn" href="{{ route("admin.$area.certificates.create") }}">+ Nuevo certificado</a></div>
<ul class="sortable" data-sortable="{{ route("admin.$area.reorder", 'certificates') }}">
@forelse($certificates as $c)
  <li data-id="{{ $c->id }}" draggable="true" class="{{ $c->visible ? '' : 'hidden-item' }}">
    @include('admin.partials.move')
    @if($c->previewUrl())<img class="thumb" src="{{ $c->previewUrl() }}" alt="" loading="lazy" draggable="false">@endif
    <div class="grow"><strong>{{ $c->title }}</strong> <span class="pill {{ $c->category === 'destacado' ? 'on' : '' }}">{{ \App\Models\Certificate::CATEGORIES[$c->category] }}</span><div class="muted">{{ $c->platform }} · {{ $c->year }}</div></div>
    @include('admin.partials.actions', ['resource' => 'certificates', 'item' => $c, 'edit' => route("admin.$area.certificates.edit", $c), 'destroy' => route("admin.$area.certificates.destroy", $c), 'confirm' => "¿Eliminar «{$c->title}»?"])
  </li>
@empty <p class="muted">Sin certificados.</p> @endforelse
</ul>
@endsection

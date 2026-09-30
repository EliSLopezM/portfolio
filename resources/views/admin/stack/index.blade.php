@extends('admin.layout')
@section('title', 'Tecnologías')
@section('content')
<div class="head"><div><h1>Tecnologías y soluciones</h1><p class="muted">Arrastra para ordenar categorías y tecnologías. Nivel: <em>Dominio</em> o <em>En estudio</em>.</p></div></div>

<ul class="sortable" data-sortable="{{ route("admin.$area.reorder", 'stack-categories') }}">
@foreach($categories as $cat)
  <li data-id="{{ $cat->id }}" draggable="true" style="display:block" class="{{ $cat->visible ? '' : 'hidden-item' }}">
    <div style="display:flex;gap:.85rem;align-items:center;flex-wrap:wrap;margin-bottom:.75rem">
      @include('admin.partials.move')
      <div style="flex:1;min-width:180px"><h3>{{ $cat->name }} @if($cat->featured)<span class="pill on">★ Favorita</span>@endif</h3><span class="muted">{{ $cat->description }}</span></div>
      @include('admin.partials.actions', ['resource' => 'stack-categories', 'item' => $cat, 'edit' => route("admin.$area.stack.categories.edit", $cat), 'destroy' => route("admin.$area.stack.categories.destroy", $cat), 'confirm' => "¿Eliminar la categoría «{$cat->name}» y sus {$cat->items->count()} tecnologías?"])
    </div>
    <ul class="sortable" data-sortable="{{ route("admin.$area.reorder", 'stack-items') }}" style="margin-left:1.5rem">
      @forelse($cat->items as $item)
      <li data-id="{{ $item->id }}" draggable="true" class="{{ $item->visible ? '' : 'hidden-item' }}" style="background:var(--bg2)">
        @include('admin.partials.move')
        @if($item->iconUrl())<img class="thumb" style="width:32px;height:32px;object-fit:contain" src="{{ $item->iconUrl() }}" alt="" loading="lazy" draggable="false">@endif
        <div style="flex:1;min-width:0"><strong>{{ $item->name }}</strong> <span class="pill {{ $item->level === 'dominio' ? 'on' : '' }}">{{ \App\Models\StackItem::LEVELS[$item->level] }}</span><div class="muted">{{ $item->type }}</div></div>
        @include('admin.partials.actions', ['resource' => 'stack-items', 'item' => $item, 'edit' => route("admin.$area.stack.items.edit", $item), 'destroy' => route("admin.$area.stack.items.destroy", $item), 'confirm' => "¿Eliminar {$item->name}?"])
      </li>
      @empty <li class="muted">Sin tecnologías en esta categoría.</li> @endforelse
    </ul>
  </li>
@endforeach
</ul>

<div class="row">
  <form class="card" method="POST" action="{{ route("admin.$area.stack.items.store") }}" enctype="multipart/form-data">@csrf
    <h2>Agregar tecnología</h2>
    @include('admin.stack._item_fields', ['item' => new \App\Models\StackItem(['level' => 'dominio']), 'categories' => $categories])
    <button class="btn" type="submit">Agregar</button>
  </form>
  <form class="card" method="POST" action="{{ route("admin.$area.stack.categories.store") }}">@csrf
    <h2>Nueva categoría</h2>
    @include('admin.stack._category_fields', ['category' => new \App\Models\StackCategory()])
    <button class="btn" type="submit">Crear categoría</button>
  </form>
</div>
@endsection

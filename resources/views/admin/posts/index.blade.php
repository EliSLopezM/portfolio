@extends('admin.layout')
@section('title', 'Blogs')
@section('content')
<div class="head"><div><h1>Blogs {{ $area === 'dcc' ? 'DCC' : 'Develop' }}</h1><p class="muted">Visualizaciones y «me gusta» en tiempo real. Copia el enlace para promocionar cada blog en tus redes.</p></div>
  <a class="btn" href="{{ route("admin.$area.posts.create") }}">+ Nuevo blog</a></div>

<form class="actions-bar" method="GET" style="margin-bottom:1rem">
  <input type="search" name="q" value="{{ request('q') }}" placeholder="Buscar por título…" style="max-width:280px" aria-label="Buscar">
  <select name="estado" style="width:auto" aria-label="Estado"><option value="">Todos</option><option value="publicado" @selected(request('estado')==='publicado')>Publicados</option><option value="borrador" @selected(request('estado')==='borrador')>Borradores</option></select>
  <button class="btn ghost" type="submit">Filtrar</button>
</form>

<div class="card table-wrap">
  <table>
    <thead><tr><th>Título</th><th>Estado</th><th>Vistas</th><th>♥</th><th>Fecha</th><th></th></tr></thead>
    <tbody>
    @forelse($posts as $p)
      <tr>
        <td><a href="{{ route("admin.$area.posts.edit", $p) }}"><strong>{{ $p->title }}</strong></a><div class="muted">{{ $p->category }} · por {{ $p->author }}</div></td>
        <td><span class="pill {{ $p->published ? 'on' : 'off' }}">{{ $p->published ? 'Publicado' : 'Borrador' }}</span></td>
        <td class="mono">{{ number_format($p->views) }}</td>
        <td class="mono">{{ number_format($p->likes) }}</td>
        <td class="muted mono">{{ ($p->published_at ?? $p->created_at)->format('d/m/Y') }}</td>
        <td><div class="actions">
          @if($p->published)
            <a class="btn ghost sm" href="{{ $p->publicUrl() }}" target="_blank" rel="noopener">Ver</a>
            <button class="btn ghost sm" type="button" data-copy="{{ $p->publicUrl() }}">Copiar link</button>
          @endif
          <a class="btn ghost sm" href="{{ route("admin.$area.posts.edit", $p) }}">Editar</a>
          <form method="POST" action="{{ route("admin.$area.posts.destroy", $p) }}" data-confirm="¿Eliminar «{{ $p->title }}»?">@csrf @method('DELETE')<button class="btn danger sm" type="submit">Eliminar</button></form>
        </div></td>
      </tr>
    @empty
      <tr><td colspan="6" class="muted">No hay blogs todavía.</td></tr>
    @endforelse
    </tbody>
  </table>
</div>
{{ $posts->links() }}
@endsection

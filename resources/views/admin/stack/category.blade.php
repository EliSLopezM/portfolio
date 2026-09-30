@extends('admin.layout')
@section('title', 'Editar categoría')
@section('content')
<div class="head"><h1>Editar categoría</h1><a class="btn ghost" href="{{ route("admin.$area.stack.index") }}">← Volver</a></div>
<form class="card" method="POST" action="{{ route("admin.$area.stack.categories.update", $category) }}">@csrf @method('PUT')
  @include('admin.stack._category_fields')
  <button class="btn" type="submit">Guardar</button>
</form>
@endsection

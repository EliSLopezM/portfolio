@extends('admin.layout')
@section('title', 'Editar tecnología')
@section('content')
<div class="head"><h1>Editar {{ $item->name }}</h1><a class="btn ghost" href="{{ route("admin.$area.stack.index") }}">← Volver</a></div>
<form class="card" method="POST" action="{{ route("admin.$area.stack.items.update", $item) }}" enctype="multipart/form-data">@csrf @method('PUT')
  @include('admin.stack._item_fields')
  <button class="btn" type="submit">Guardar</button>
</form>
@endsection

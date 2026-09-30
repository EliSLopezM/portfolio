@extends('admin.layout')
@section('title', 'Mensaje de ' . $message->nombre)
@section('content')
@php $labels = config('admin.message_statuses'); @endphp
<div class="head"><div><h1>{{ $message->nombre }}</h1><p class="muted">{{ $message->created_at->format('d/m/Y H:i') }}@if($message->recaptcha_score) · reCAPTCHA {{ number_format($message->recaptcha_score, 1) }}@endif</p></div>
  <a class="btn ghost" href="{{ route("admin.$area.messages.index") }}">← Volver</a></div>

<div class="cols">
  <div class="card">
    <h2>{{ $message->asunto ?: 'Sin asunto' }}</h2>
    <p style="white-space:pre-wrap;word-break:break-word">{{ $message->mensaje }}</p>
  </div>
  <div>
    <div class="card">
      <h2>Contacto</h2>
      <p><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></p>
      @if($message->phone_number)<p class="mono">{{ $message->phone_country_code }} {{ $message->phone_number }}</p>@endif
    </div>
    <form class="card" method="POST" action="{{ route("admin.$area.messages.update", $message) }}">@csrf @method('PUT')
      <h2>Estados</h2>
      <div class="statuses" style="flex-direction:column;gap:.5rem;margin-bottom:1rem">
        @foreach($labels as $key => $label)
          <label class="check"><input type="checkbox" name="statuses[]" value="{{ $key }}" @checked($message->hasStatus($key))> {{ $label }}</label>
        @endforeach
      </div>
      <button class="btn" type="submit">Guardar estados</button>
    </form>
    <form method="POST" action="{{ route("admin.$area.messages.destroy", $message) }}" data-confirm="¿Eliminar este mensaje?">@csrf @method('DELETE')
      <button class="btn danger" type="submit">Eliminar mensaje</button>
    </form>
  </div>
</div>
@endsection

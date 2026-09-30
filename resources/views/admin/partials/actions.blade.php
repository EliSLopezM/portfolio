{{-- Acciones comunes de una fila: visibilidad, editar y eliminar. Requiere $resource, $item, $area; opcional $edit, $destroy, $noToggle. --}}
<div class="actions">
  @unless(!empty($noToggle))
  <form method="POST" action="{{ route("admin.$area.toggle", [$resource, $item->id]) }}">@csrf
    <button type="submit" class="pill {{ $item->visible ? 'on' : 'off' }}" title="Mostrar u ocultar en el sitio">{{ $item->visible ? '● Visible' : '○ Oculto' }}</button>
  </form>
  @endunless
  @isset($edit)<a class="btn ghost sm" href="{{ $edit }}">Editar</a>@endisset
  @isset($destroy)
  <form method="POST" action="{{ $destroy }}" data-confirm="{{ $confirm ?? '¿Eliminar definitivamente?' }}">@csrf @method('DELETE')
    <button type="submit" class="btn danger sm">Eliminar</button>
  </form>
  @endisset
</div>

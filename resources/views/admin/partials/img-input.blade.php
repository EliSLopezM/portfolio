{{-- Campo de imagen con el tamaño ideal del preset (config/images.php). Requiere $name, $preset; opcional $id, $multiple, $required. --}}
@php $p = \App\Services\ImageProcessor::preset($preset); @endphp
<input type="file" @isset($id) id="{{ $id }}" @endisset name="{{ $name }}{{ !empty($multiple) ? '[]' : '' }}" accept="image/jpeg,image/png,image/webp,image/gif"
       data-w="{{ $p['w'] }}" data-h="{{ $p['h'] ?? '' }}" data-mode="{{ $p['mode'] }}" @if(!empty($multiple)) multiple @endif @if(!empty($required)) required @endif>
<p class="hint img-hint">
  <strong>{{ $p['w'] }}{{ $p['h'] ? ' × ' . $p['h'] : '' }} px</strong> ideal
  ({{ $p['mode'] === 'cover' ? 'se recorta al centro para llenar el marco' : 'se reduce sin deformar' }}) · {{ $p['note'] }} · máx. {{ round(config('images.max_upload_kb') / 1024) }} MB · JPG, PNG, WEBP o GIF (se guarda en WebP).
  <span class="img-warn" hidden></span>
</p>

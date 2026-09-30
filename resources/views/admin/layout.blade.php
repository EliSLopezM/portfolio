<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="robots" content="noindex, nofollow, noarchive">
  <title>@yield('title', 'Dashboard') — Admin</title>
  <link rel="icon" type="image/png" href="{{ asset('elilogo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Mono:wght@400;500&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body data-area="{{ $area ?? 'hub' }}">
@php
  $unread = \App\Models\Message::unread()->count();
  $nav = ($area ?? null) === 'dcc' ? [
      ['home', 'Resumen'], ['posts.index', 'Blogs'], ['media.index', 'Imágenes'], ['events.index', 'Calendario'],
  ] : [
      ['home', 'Resumen'], ['posts.index', 'Blogs'], ['media.index', 'Imágenes'], ['settings.edit', 'Enlaces y cifras'],
      ['stack.index', 'Tecnologías'], ['projects.index', 'Trabajo real'], ['certificates.index', 'Certificados'], ['messages.index', 'Mensajes'],
  ];
@endphp
<div class="shell">
  <aside class="side">
    <div class="brand">Dashboard<small>{{ ($area ?? null) === 'dcc' ? 'Admin · DCC' : (($area ?? null) === 'develop' ? 'Admin · Develop' : 'Admin') }}</small></div>
    @if(!empty($area))
    <nav aria-label="Secciones">
      @foreach($nav as [$route, $label])
        @php $active = $route === 'home' ? request()->routeIs("admin.$area.home") : request()->routeIs("admin.$area." . strtok($route, '.') . '.*'); @endphp
        <a href="{{ route("admin.$area.$route") }}" class="{{ $active ? 'active' : '' }}">
          {{ $label }}
          @if($route === 'messages.index' && $unread) <span class="badge">{{ $unread }}</span> @endif
        </a>
      @endforeach
    </nav>
    @endif
    <div class="foot">
      <a href="{{ route('admin.index') }}">← Cambiar de panel</a>
      <a href="{{ ($area ?? null) === 'dcc' ? route('dcc.index') : route('portfolio') }}" target="_blank" rel="noopener">Ver sitio ↗</a>
      <form method="POST" action="{{ route('logout') }}">@csrf <button class="btn ghost sm" type="submit">Cerrar sesión</button></form>
    </div>
  </aside>
  <main>
    @if(session('status')) <div class="flash ok" role="status">{{ session('status') }}</div> @endif
    @if($errors->any())
      <div class="flash bad" role="alert"><strong>Revisa el formulario:</strong>
        <ul style="margin:.4rem 0 0 1.2rem">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
      </div>
    @endif
    @yield('content')
  </main>
</div>
<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>

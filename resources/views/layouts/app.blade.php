<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', $portfolio['name'] . ' — ' . $portfolio['role'])</title>
  <meta name="description" content="@yield('description', $portfolio['tagline'])">

  {{-- Open Graph --}}
  <meta property="og:title" content="@yield('title', $portfolio['name'])">
  <meta property="og:description" content="@yield('description', $portfolio['tagline'])">
  <meta property="og:image" content="{{ asset('images/elilogo.png') }}">
  <meta property="og:type" content="website">

  {{-- Favicon --}}
  <link rel="icon" type="image/png" href="{{ asset('elilogo.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('elilogo.png') }}">

  {{-- Fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Mono:wght@400;500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @stack('head')
</head>
<body>
  <div class="cursor-dot" id="cursorDot"></div>
  <div class="cursor-ring" id="cursorRing"></div>
  @include('partials.nav')
  <main>
    @yield('content')
  </main>
  @include('partials.footer')
  <script src="{{ asset('js/app.js') }}"></script>
  @stack('scripts')
</body>
</html>
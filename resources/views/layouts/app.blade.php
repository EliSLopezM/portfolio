<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $portfolio['name'] }} — {{ $portfolio['role'] }}</title>
  <meta name="description" content="{{ $portfolio['tagline'] }}" />
  <meta property="og:title" content="{{ $portfolio['name'] }} — {{ $portfolio['role'] }}" />
  <meta property="og:description" content="{{ $portfolio['tagline'] }}" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Mono:wght@400;500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />

  {{-- Vite (para producción): @vite(['resources/css/app.css','resources/js/app.js']) --}}
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  @stack('head')
</head>
<body>

  @include('partials.nav')

  <main>
    @yield('content')
  </main>

  @include('partials.footer')

  <script src="{{ asset('js/app.js') }}"></script>
  @stack('scripts')

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow, noarchive">
  <title>Acceso — Dashboard</title>
  <link rel="icon" type="image/png" href="{{ asset('elilogo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Mono:wght@400;500&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
  <div class="center">
    <div class="login-box">
      <h1>Acceso privado</h1>
      <p class="muted" style="margin-bottom:1.5rem">Dashboard de Eli Santiago López Mahecha</p>

      <form id="loginForm" class="card" method="POST" action="{{ route('login.store') }}" autocomplete="off"
            data-sitekey="{{ config('services.recaptcha.site_key') }}">
        @csrf
        @error('username') <div class="flash bad">{{ $message }}</div> @enderror
        @error('password') <div class="flash bad">{{ $message }}</div> @enderror
        @error('website') <div class="flash bad">Solicitud no válida.</div> @enderror

        <div class="field">
          <label for="username">Usuario</label>
          <input type="text" id="username" name="username" value="{{ old('username') }}" maxlength="50" required autofocus
                 autocomplete="username" pattern="[A-Za-z0-9._-]+" inputmode="text" autocapitalize="off" spellcheck="false">
        </div>
        <div class="field">
          <label for="password">Contraseña</label>
          <input type="password" id="password" name="password" maxlength="200" required autocomplete="current-password">
        </div>

        {{-- Honeypot: los bots lo rellenan, las personas no lo ven. --}}
        <div class="hp" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>
        <input type="hidden" name="g-recaptcha-response" id="recaptchaToken">

        <button class="btn" type="submit" style="width:100%;justify-content:center">Entrar</button>
        <p class="hint" style="margin-top:1rem">Protegido con reCAPTCHA v3. Aplican la <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer">Política de Privacidad</a> y los <a href="https://policies.google.com/terms" target="_blank" rel="noopener noreferrer">Términos</a> de Google.</p>
      </form>
    </div>
  </div>
  @if(config('services.recaptcha.site_key'))
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}" async defer></script>
  @endif
  <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>

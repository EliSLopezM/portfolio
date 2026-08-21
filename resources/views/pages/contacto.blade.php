@extends('layouts.app')
@section('title', 'Contacto — Eli Santiago López')
@section('description', 'Disponible para proyectos freelance y posiciones remote.')
@section('content')
<section class="page-section section-light">
  <div class="container">
    <div class="page-header">
      <span class="section-label">// contacto</span>
      <h1 class="section-title">¿Hablamos de<br>tu proyecto?</h1>
      <p class="page-intro">Disponible para proyectos freelance, posiciones remote o simplemente para intercambiar ideas. Respondo en menos de 24h.</p>
    </div>
    <div class="contact-grid">
      <div class="contact-form-wrap">
        @if(session('success'))
          <div class="alert-success">{{ session('success') }}</div>
        @endif
        <form class="contact-form" action="{{ route('contact') }}" method="POST" novalidate>
          @csrf
          <div class="form-row">
            <div class="form-group {{ $errors->has('nombre') ? 'has-error' : '' }}">
              <label for="nombre">NOMBRE</label>
              <input id="nombre" name="nombre" type="text" placeholder="Tu nombre" value="{{ old('nombre') }}" required/>
              @error('nombre') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
              <label for="email">EMAIL</label>
              <input id="email" name="email" type="email" placeholder="tu@empresa.com" value="{{ old('email') }}" required/>
              @error('email') <span class="form-error">{{ $message }}</span> @enderror
            </div>
          </div>
          <div class="form-group">
            <label for="asunto">ASUNTO</label>
            <input id="asunto" name="asunto" type="text" maxlength="200" placeholder="Proyecto, consultoría, etc." value="{{ old('asunto') }}"/>
          </div>
          <div class="form-group">
            <label for="phone_number">TELÉFONO *</label>
            <div class="phone-fields">
              <div class="country-picker" data-country-picker>
                <input type="hidden" id="phone_country_iso" name="phone_country_iso" value="{{ old('phone_country_iso', 'CO') }}">
                <button type="button" class="country-picker-button" aria-haspopup="listbox" aria-expanded="false">
                  <span class="fi fi-co country-flag" data-country-flag aria-hidden="true"></span>
                  <span data-country-label>+57 Colombia</span>
                  <span class="country-picker-chevron" aria-hidden="true">⌄</span>
                </button>
                <div class="country-picker-menu" role="listbox" tabindex="-1">
                  <button type="button" role="option" data-country="CO" data-code="+57" data-label="+57 Colombia" class="country-option"><span class="fi fi-co country-flag" aria-hidden="true"></span><span>+57 Colombia</span></button>
                  <button type="button" role="option" data-country="PR" data-code="+1" data-label="+1 Puerto Rico" class="country-option"><span class="fi fi-pr country-flag" aria-hidden="true"></span><span>+1 Puerto Rico</span></button>
                  <button type="button" role="option" data-country="US" data-code="+1" data-label="+1 Estados Unidos" class="country-option"><span class="fi fi-us country-flag" aria-hidden="true"></span><span>+1 Estados Unidos</span></button>
                  <button type="button" role="option" data-country="MX" data-code="+52" data-label="+52 México" class="country-option"><span class="fi fi-mx country-flag" aria-hidden="true"></span><span>+52 México</span></button>
                  <button type="button" role="option" data-country="ES" data-code="+34" data-label="+34 España" class="country-option"><span class="fi fi-es country-flag" aria-hidden="true"></span><span>+34 España</span></button>
                  <button type="button" role="option" data-country="AR" data-code="+54" data-label="+54 Argentina" class="country-option"><span class="fi fi-ar country-flag" aria-hidden="true"></span><span>+54 Argentina</span></button>
                  <button type="button" role="option" data-country="CL" data-code="+56" data-label="+56 Chile" class="country-option"><span class="fi fi-cl country-flag" aria-hidden="true"></span><span>+56 Chile</span></button>
                  <button type="button" role="option" data-country="PE" data-code="+51" data-label="+51 Perú" class="country-option"><span class="fi fi-pe country-flag" aria-hidden="true"></span><span>+51 Perú</span></button>
                </div>
              </div>
              <input type="hidden" id="phone_country_code" name="phone_country_code" value="{{ old('phone_country_code', '+57') }}" required>
              <input id="phone_number" name="phone_number" type="tel" inputmode="tel" maxlength="20" pattern="[0-9 ()-]{7,20}" placeholder="300 123 4567" value="{{ old('phone_number') }}" aria-describedby="phone-help" required>
            </div>
            <small id="phone-help" class="form-help">Incluye solo números, espacios, paréntesis o guiones.</small>
            @error('phone_number') <span class="form-error">{{ $message }}</span> @enderror
          </div>
          <div class="form-group {{ $errors->has('mensaje') ? 'has-error' : '' }}">
            <label for="mensaje">MENSAJE</label>
            <textarea id="mensaje" name="mensaje" rows="6" maxlength="1500" placeholder="Cuéntame sobre tu proyecto..." required>{{ old('mensaje') }}</textarea>
            @error('mensaje') <span class="form-error">{{ $message }}</span> @enderror
          </div>
          @if(config('services.recaptcha.site_key'))
            <div class="form-group {{ $errors->has('recaptcha') ? 'has-error' : '' }}">
              <input type="hidden" name="g-recaptcha-response" id="recaptcha-token-contact">
              @error('recaptcha') <span class="form-error">{{ $message }}</span> @enderror
            </div>
          @endif
          <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" class="honeypot">
          <p class="recaptcha-notice">Este formulario está protegido con reCAPTCHA v3. Aplican la <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Política de Privacidad</a> y los <a href="https://policies.google.com/terms" target="_blank" rel="noopener">Términos de Google</a>.</p>
          <button type="submit" class="btn btn-primary btn-full">Enviar mensaje →</button>
        </form>
        <div class="contact-links">
          <a href="{{ $portfolio['github'] }}"   target="_blank" rel="noopener" class="contact-link">↗ github.com/EliSLopezM</a>
          <a href="{{ $portfolio['linkedin'] }}" target="_blank" rel="noopener" class="contact-link">↗ linkedin.com/in/eli-santiago</a>
          <a href="mailto:{{ $portfolio['email'] }}" class="contact-link">↗ {{ $portfolio['email'] }}</a>
          <a href="tel:{{ $portfolio['phone'] }}"    class="contact-link">↗ {{ $portfolio['phone'] }}</a>
        </div>
      </div>
      <div class="contact-map-wrap">
        <div class="map-label">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
          Ciudad Bolívar, Bogotá — Colombia
        </div>
        <div class="map-container">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63728.85887847566!2d-74.18441565!3d4.5539!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9f9fdcecaf43%3A0x93386d1caf86e5bc!2sCiudad%20Bol%C3%ADvar%2C%20Bogot%C3%A1!5e0!3m2!1ses!2sco!4v1700000000000" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </div>
</section>
@if(config('services.recaptcha.site_key'))
  @push('scripts')
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}" async defer></script>
    <script>
      document.querySelector('.contact-form')?.addEventListener('submit', function (event) {
        event.preventDefault();
        grecaptcha.ready(() => grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', { action: 'contact' }).then((token) => {
          document.getElementById('recaptcha-token-contact').value = token;
          event.target.submit();
        }));
      });
    </script>
  @endpush
@endif
@endsection
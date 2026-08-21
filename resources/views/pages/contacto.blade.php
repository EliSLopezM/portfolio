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
            <input id="asunto" name="asunto" type="text" placeholder="Proyecto, consultoría, etc." value="{{ old('asunto') }}"/>
          </div>
          <div class="form-group {{ $errors->has('mensaje') ? 'has-error' : '' }}">
            <label for="mensaje">MENSAJE</label>
            <textarea id="mensaje" name="mensaje" rows="6" placeholder="Cuéntame sobre tu proyecto..." required>{{ old('mensaje') }}</textarea>
            @error('mensaje') <span class="form-error">{{ $message }}</span> @enderror
          </div>
          @if(config('services.recaptcha.site_key'))
            <div class="form-group {{ $errors->has('recaptcha') ? 'has-error' : '' }}">
              <input type="hidden" name="g-recaptcha-response" id="recaptcha-token-contact">
              @error('recaptcha') <span class="form-error">{{ $message }}</span> @enderror
            </div>
          @endif
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
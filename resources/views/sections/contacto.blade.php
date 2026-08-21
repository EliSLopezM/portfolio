<section class="page-section section-light">
  <div class="container">
    <div class="section-header">
      <span class="section-label">// 05 — contacto</span>
      <h2 class="section-title">¿Hablamos de<br>tu proyecto?</h2>
    </div>

    <div class="contact-wrap">
      <p class="contact-intro">
        Estoy disponible para proyectos freelance, posiciones full-time/remote,
        o simplemente para intercambiar ideas sobre Laravel y desarrollo backend.
        Escríbeme y te respondo en menos de 24 horas.
      </p>

      @if(session('success'))
        <div class="alert-success">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
          {{ session('success') }}
        </div>
      @endif

      <form
        class="contact-form"
        action="{{ route('contact') }}"
        method="POST"
        novalidate
      >
        @csrf

        <div class="form-row">
          <div class="form-group {{ $errors->has('nombre') ? 'has-error' : '' }}">
            <label for="nombre">NOMBRE</label>
            <input
              id="nombre" name="nombre" type="text"
              maxlength="100"
              placeholder="Tu nombre"
              value="{{ old('nombre') }}"
              required
            />
            @error('nombre')
              <span class="form-error">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="email">EMAIL</label>
            <input
              id="email" name="email" type="email"
              maxlength="150"
              placeholder="tu@empresa.com"
              value="{{ old('email') }}"
              required
            />
            @error('email')
              <span class="form-error">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-group">
          <label for="asunto">ASUNTO</label>
          <input
            id="asunto" name="asunto" type="text"
            maxlength="200"
            placeholder="Proyecto freelance, consultoría, etc."
            value="{{ old('asunto') }}"
          />
        </div>

        <div class="form-group">
          <label for="phone_number_home">TELÉFONO *</label>
          <div class="phone-fields">
            <div class="country-picker" data-country-picker>
              <input type="hidden" id="phone_country_iso_home" name="phone_country_iso" value="{{ old('phone_country_iso', 'CO') }}">
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
              </div>
            </div>
            <input type="hidden" id="phone_country_code_home" name="phone_country_code" value="{{ old('phone_country_code', '+57') }}" required>
            <input id="phone_number_home" name="phone_number" type="tel" inputmode="tel" maxlength="20" pattern="[0-9 ()-]{7,20}" placeholder="301 425 5344" value="{{ old('phone_number') }}" required>
          </div>
        </div>

        <div class="form-group {{ $errors->has('mensaje') ? 'has-error' : '' }}">
          <label for="mensaje">MENSAJE</label>
          <textarea
            id="mensaje" name="mensaje" rows="5"
            maxlength="1500"
            placeholder="Cuéntame sobre tu proyecto o propuesta..."
            required
          >{{ old('mensaje') }}</textarea>
          @error('mensaje')
            <span class="form-error">{{ $message }}</span>
          @enderror
        </div>

        @if(config('services.recaptcha.site_key'))
          <div class="form-group {{ $errors->has('recaptcha') ? 'has-error' : '' }}">
            <input type="hidden" name="g-recaptcha-response" id="recaptcha-token-home">
            @error('recaptcha')
              <span class="form-error">{{ $message }}</span>
            @enderror
          </div>
        @endif
        <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" class="honeypot">
        <p class="recaptcha-notice">Este formulario está protegido con reCAPTCHA v3. Aplican la <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Política de Privacidad</a> y los <a href="https://policies.google.com/terms" target="_blank" rel="noopener">Términos de Google</a>.</p>

        <button type="submit" class="btn btn-primary btn-full">
          Enviar mensaje →
        </button>
      </form>

      <div class="contact-links">
        <a href="{{ $portfolio['github'] }}" target="_blank" rel="noopener" class="contact-link">
          ↗ github.com/EliSLopezM
        </a>
        <a href="{{ $portfolio['linkedin'] }}" target="_blank" rel="noopener" class="contact-link">
          ↗ linkedin.com/in/eli-santiago
        </a>
        <a href="mailto:{{ $portfolio['email'] }}" class="contact-link">
          ↗ {{ $portfolio['email'] }}
        </a>
        <a href="tel:{{ $portfolio['phone'] }}" class="contact-link">
          ↗ {{ $portfolio['phone'] }}
        </a>
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
          document.getElementById('recaptcha-token-home').value = token;
          event.target.submit();
        }));
      });
    </script>
  @endpush
@endif

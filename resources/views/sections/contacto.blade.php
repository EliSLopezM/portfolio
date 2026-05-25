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
            placeholder="Proyecto freelance, consultoría, etc."
            value="{{ old('asunto') }}"
          />
        </div>

        <div class="form-group {{ $errors->has('mensaje') ? 'has-error' : '' }}">
          <label for="mensaje">MENSAJE</label>
          <textarea
            id="mensaje" name="mensaje" rows="5"
            placeholder="Cuéntame sobre tu proyecto o propuesta..."
            required
          >{{ old('mensaje') }}</textarea>
          @error('mensaje')
            <span class="form-error">{{ $message }}</span>
          @enderror
        </div>

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

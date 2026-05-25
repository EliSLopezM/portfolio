<section id="hero" class="hero">
  <div class="hero-bg"></div>
  <div class="hero-grid-line"></div>

  <div class="hero-inner">
    <div class="hero-tag">
      <span class="hero-dot {{ $portfolio['available'] ? 'active' : '' }}"></span>
      {{ $portfolio['available'] ? 'disponible para proyectos' : 'no disponible actualmente' }}
    </div>

    <h1 class="hero-title">
      Eli Santiago<br><em>López</em>
    </h1>

    <p class="hero-role">Ingeniero de Sistemas &amp; Full Stack Developer</p>

    <p class="hero-sub">
      {{ $portfolio['tagline'] }}
    </p>

    <div class="hero-actions">
      <a href="#proyectos" class="btn btn-primary">Ver proyectos →</a>
      <a href="{{ $portfolio['cv_path'] }}" class="btn btn-outline" download>Descargar CV</a>
      <a href="{{ route('contact.view') }}" class="btn btn-ghost">Trabajemos juntos</a>
    </div>

    <div class="hero-socials">
      <a href="{{ $portfolio['github'] }}" target="_blank" rel="noopener" class="social-btn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
        GitHub
      </a>
      <a href="{{ $portfolio['linkedin'] }}" target="_blank" rel="noopener" class="social-btn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
        LinkedIn
      </a>
      <button class="social-btn social-btn-email" id="emailBtn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
        Email
      </button>
    </div>
  </div>

  {{-- FOTO --}}
  <div class="hero-photo-wrap">
    <img src="{{ asset('images/EliWeb.png') }}" alt="Eli Santiago López" class="hero-photo" />
  </div>

  <div class="hero-scroll">scroll</div>
</section>

{{-- MODAL EMAIL --}}
<div class="email-modal-overlay" id="emailModal">
  <div class="email-modal">
    <button class="email-modal-close" id="emailModalClose">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <div class="email-modal-icon">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
    </div>
    <h3 class="email-modal-title">Enviar mensaje</h3>
    <p class="email-modal-sub">Hola Eli, estoy interesado en tu perfil</p>
    <a href="mailto:{{ $portfolio['email'] }}?subject=Interesado en tu perfil profesional&body=Hola Eli,%0D%0A%0D%0AEstoy interesado en tu perfil profesional y me gustaría conocer más sobre tu disponibilidad y servicios.%0D%0A%0D%0AQuedo atento a tu respuesta.%0D%0A%0D%0ASaludos,"
       class="btn btn-primary btn-full email-modal-btn">
      Abrir en correo →
    </a>
    <p class="email-modal-direct">O escríbeme directo a <strong>{{ $portfolio['email'] }}</strong></p>
  </div>
</div>
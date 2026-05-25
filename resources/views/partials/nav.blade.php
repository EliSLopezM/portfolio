<nav class="nav" id="navbar">
  <a href="{{ route('portfolio') }}" class="nav-home-btn" title="Inicio">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
  </a>
  <ul class="nav-links" id="navLinks">
    <li>
      <a href="{{ route('portfolio') }}#sobre" class="nav-link {{ request()->routeIs('portfolio') ? 'active' : '' }}">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Sobre mí
      </a>
    </li>
    <li>
      <a href="{{ route('portfolio') }}#stack-section" class="nav-link {{ request()->routeIs('stack') ? 'active' : '' }}">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
        Stack
      </a>
    </li>
    <li>
      <a href="{{ route('proyectos') }}" class="nav-link {{ request()->routeIs('proyectos') ? 'active' : '' }}">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        Proyectos
      </a>
    </li>
    <li>
      <a href="{{ route('portfolio') }}#experiencia-section" class="nav-link {{ request()->routeIs('experiencia') ? 'active' : '' }}">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        Experiencia
      </a>
    </li>
    <li>
      <a href="{{ route('contact.view') }}" class="nav-link {{ request()->routeIs('contact.view') ? 'active' : '' }}">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.1 19.79 19.79 0 0 1 1.61 4.56C1.6 3.47 2.33 2.5 3.42 2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.18 6.18l1.29-1.29a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        Contacto
      </a>
    </li>
  </ul>
  <button class="nav-toggle" id="navToggle" aria-label="Menú">
    <span></span><span></span><span></span>
  </button>
</nav>
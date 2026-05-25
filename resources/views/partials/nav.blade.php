<nav class="nav" id="navbar">
  <a href="{{ route('portfolio') }}" class="nav-logo">eli_lopez.php</a>
  <ul class="nav-links">
    <li><a href="{{ route('portfolio') }}">Sobre mí</a></li>
    <li><a href="{{ route('stack') }}">Stack</a></li>
    <li><a href="{{ route('proyectos') }}">Proyectos</a></li>
    <li><a href="{{ route('experiencia') }}">Experiencia</a></li>
    <li><a href="{{ route('contact.view') }}">Contacto</a></li>
  </ul>
  <button class="nav-toggle" id="navToggle" aria-label="Abrir menú">
    <span></span><span></span><span></span>
  </button>
</nav>

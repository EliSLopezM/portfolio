<footer class="footer">
  <p class="footer-text">© {{ date('Y') }} {{ config('portfolio.name') }} — Bogotá, Colombia</p>
  <div class="footer-links">
    <a href="{{ config('portfolio.github') }}" target="_blank" rel="noopener" class="footer-link">GitHub ↗</a>
    <a href="{{ config('portfolio.linkedin') }}" target="_blank" rel="noopener" class="footer-link">LinkedIn ↗</a>
    <a href="mailto:{{ config('portfolio.email') }}" class="footer-link">Email ↗</a>
  </div>
  <a href="#" class="footer-top">↑ volver arriba</a>
</footer>

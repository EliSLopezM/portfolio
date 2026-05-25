<section id="stack" class="section section-light">
  <div class="container">
    <div class="section-header">
      <span class="section-label">// 02 — stack</span>
      <h2 class="section-title">Tecnologías con las<br>que construyo soluciones</h2>
    </div>

    <div class="stack-flip-grid">
      @foreach($portfolio['stack'] as $item)
      <div class="stack-flip-card {{ isset($item['level']) && $item['level'] === 'conocimiento' ? 'stack-flip-secondary' : '' }}">
        <div class="stack-flip-inner">
          <div class="stack-flip-front">
            <div class="stack-flip-icon">{!! $item['svg'] !!}</div>
            <div class="stack-flip-name">{{ $item['name'] }}</div>
            @if(isset($item['level']) && $item['level'] === 'conocimiento')
              <span class="stack-flip-badge">Conocimiento</span>
            @endif
          </div>
          <div class="stack-flip-back">
            <div class="stack-flip-type">{{ $item['type'] }}</div>
            @if(isset($item['level']) && $item['level'] === 'conocimiento')
              <div class="stack-flip-note">Cursos & proyectos personales</div>
            @else
              <div class="stack-flip-note">Uso diario en producción</div>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <div class="stack-combo">
      <div class="stack-combo-inner">
        <div class="combo-icon">
          <svg viewBox="0 0 24 24" fill="#DD0031" width="28" height="28"><path d="M9.931 12.645h4.138l-2.07-4.908m0-7.737L.68 3.982l1.726 14.771L12 24l9.586-5.242L23.32 3.982 11.999.0zm7.064 18.31h-2.638l-1.422-3.503H8.996l-1.422 3.504h-2.64L12 2.65z"/></svg>
        </div>
        <span class="combo-plus">+</span>
        <div class="combo-icon">
          <svg viewBox="0 0 24 24" fill="#FF2D20" width="28" height="28"><path d="M23.642 5.43a.364.364 0 0 1 .014.1v5.149c0 .135-.073.26-.189.326l-4.323 2.49v4.934a.378.378 0 0 1-.188.326L9.93 23.949a.316.316 0 0 1-.066.027.236.236 0 0 1-.048.013.347.347 0 0 1-.187 0 .326.326 0 0 1-.06-.02L.492 18.754a.377.377 0 0 1-.19-.325V3.782a.364.364 0 0 1 .015-.1.233.233 0 0 1 .02-.05.315.315 0 0 1 .073-.096l4.514-2.61a.38.38 0 0 1 .379 0l4.514 2.61a.32.32 0 0 1 .073.095.218.218 0 0 1 .02.051.364.364 0 0 1 .014.1v9.683l3.755-2.164V5.53a.364.364 0 0 1 .014-.1.218.218 0 0 1 .02-.051.316.316 0 0 1 .073-.095l4.514-2.61a.38.38 0 0 1 .38 0l4.514 2.61a.317.317 0 0 1 .072.096.232.232 0 0 1 .02.05z"/></svg>
        </div>
        <div class="combo-text">
          <p class="combo-title">Angular + Laravel — Full Stack real</p>
          <p class="combo-desc">Angular como SPA frontend consume la API RESTful de Laravel. Separación de responsabilidades, escalabilidad y rendimiento sin sacrificar la robustez del backend PHP.</p>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="proyectos" class="section section-alt">
  <div class="container">
    <div class="section-header">
      <span class="section-label">// 03 — proyectos</span>
      <h2 class="section-title">Trabajo real,<br>problemas reales</h2>
    </div>

    <div class="projects-grid">
      @foreach($portfolio['projects'] as $project)
      <article class="project-card">

        <div class="project-img-wrap">
          @if(file_exists(public_path('images/' . $project['image'])))
            <img
              src="{{ asset('images/' . $project['image']) }}"
              alt="Captura de {{ $project['title'] }}"
              class="project-img"
              loading="lazy"
            />
          @else
            <div class="project-img-placeholder">
              <span>{{ $project['title'] }}</span>
            </div>
          @endif
          <div class="project-overlay">
            @foreach($project['links'] as $link)
              @if($link['featured'])
                <a href="{{ $link['url'] }}" target="_blank" rel="noopener" class="overlay-btn">
                  {{ $link['label'] }} ↗
                </a>
              @endif
            @endforeach
          </div>
        </div>

        <div class="project-body">
          <div class="project-meta">
            <span class="project-company">{{ $project['company'] }}</span>
          </div>

          <div class="project-tags">
            @foreach($project['tags'] as $tag)
              <span class="tag">{{ $tag }}</span>
            @endforeach
          </div>

          <h3 class="project-title">{{ $project['title'] }}</h3>
          <p class="project-desc">{{ $project['desc'] }}</p>

          <div class="project-links">
            @foreach($project['links'] as $link)
              <a
                href="{{ $link['url'] }}"
                target="_blank"
                rel="noopener"
                class="project-link {{ $link['featured'] ? 'featured' : '' }}"
              >
                {{ $link['label'] }} ↗
              </a>
            @endforeach
            @if($project['github'])
              <a href="{{ $project['github'] }}" target="_blank" rel="noopener" class="project-link">
                GitHub →
              </a>
            @endif
          </div>
        </div>

      </article>
      @endforeach
    </div>
  </div>
</section>

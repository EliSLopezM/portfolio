<section id="sobre" class="section section-alt">
  <div class="container">
    <div class="section-header">
      <span class="section-label">// 01 — sobre mí</span>
      <h2 class="section-title">Desarrollador con foco<br>en resultados reales</h2>
    </div>

    <div class="about-grid">
      <div class="about-text">
        <p>{!! $portfolio['about']['paragraph1'] !!}</p>
        <p>{!! $portfolio['about']['paragraph2'] !!}</p>
        <p>{!! $portfolio['about']['paragraph3'] !!}</p>

        <div class="about-actions">
          <a href="{{ $portfolio['cv_path'] }}" class="btn btn-primary" download>
            Descargar CV (PDF)
          </a>
          <a href="{{ $portfolio['github'] }}" target="_blank" rel="noopener" class="btn btn-outline">
            Ver GitHub ↗
          </a>
        </div>

        <div class="languages">
          @foreach($portfolio['languages'] as $lang)
          <div class="lang-item">
            <div class="lang-header">
              <span class="lang-name">{{ $lang['name'] }}</span>
              <span class="lang-level">{{ $lang['level'] }}</span>
            </div>
            <div class="lang-bar">
              <div class="lang-fill" style="width: {{ $lang['pct'] }}%"></div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <div class="about-right">
        <div class="about-card">
          <div class="about-avatar">
            <img src="https://github.com/EliSLopezM.png" alt="Eli Santiago López" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
          </div>
          <p class="about-card-name">{{ $portfolio['name'] }}</p>
          <p class="about-card-role">{{ $portfolio['role'] }}</p>
          <div class="about-card-info">
            <div class="info-row">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="4" width="20" height="16" rx="2" />
                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
              </svg>
              {{ $portfolio['email'] }}
            </div>
            <div class="info-row">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.1 19.79 19.79 0 0 1 1.61 4.56C1.6 3.47 2.33 2.5 3.42 2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.18 6.18l1.29-1.29a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
              </svg>
              {{ $portfolio['phone'] }}
            </div>
            <div class="info-row">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 0 1 16 0z" />
                <circle cx="12" cy="10" r="3" />
              </svg>
              {{ $portfolio['location'] }}
            </div>
          </div>
        </div>

        <div class="stats-grid">
          @foreach($portfolio['stats'] as $stat)
          <div class="stat-item">
            <div class="stat-num">{{ $stat['value'] }}</div>
            <div class="stat-label">{{ $stat['label'] }}</div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
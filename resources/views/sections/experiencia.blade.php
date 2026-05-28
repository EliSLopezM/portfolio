{{-- resources/views/sections/experiencia.blade.php --}}

@include('sections.certificados', ['portfolio' => $portfolio])

<section id="experiencia" class="section">
  <div class="container">
    <div class="section-header">
      <span class="section-label">// 04 — experiencia</span>
      <h2 class="section-title">Trayectoria<br>profesional</h2>
    </div>

    <div class="timeline">
      @foreach($portfolio['experience'] as $exp)
      <div class="timeline-item {{ $exp['current'] ? 'current' : '' }}">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
          <div class="timeline-date">{{ $exp['period'] }}</div>
          <div class="timeline-role">{{ $exp['role'] }}</div>
          <div class="timeline-company">{{ $exp['company'] }}</div>
          <ul class="timeline-list">
            @foreach($exp['items'] as $item)
              <li>{{ $item }}</li>
            @endforeach
          </ul>
          <div class="timeline-tags">
            @foreach($exp['tags'] as $tag)
              <span class="tag tag-sm">{{ $tag }}</span>
            @endforeach
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
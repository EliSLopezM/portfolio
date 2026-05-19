<section id="stack" class="section">
  <div class="container">
    <div class="section-header">
      <span class="section-label">// 02 — stack</span>
      <h2 class="section-title">Herramientas con las<br>que trabajo a diario</h2>
    </div>

    <div class="stack-grid">
      @foreach($portfolio['stack'] as $item)
      <div class="stack-item">
        <div class="stack-icon">{{ $item['abbr'] }}</div>
        <div class="stack-info">
          <div class="stack-name">{{ $item['name'] }}</div>
          <div class="stack-type">{{ $item['type'] }}</div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

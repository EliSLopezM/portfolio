{{-- resources/views/sections/procesos-ia.blade.php --}}
<section id="procesos-ia" class="section ia-section">
    <div class="container">
        <div class="section-header">
            <span class="section-label">// IA aplicada</span>
            <h2>Procesos que resuelvo</h2>
        </div>

        <div class="ia-track" id="iaTrack">
            @foreach($portfolio['ai_processes'] as $process)
            <article class="ia-card">
                <div class="ia-card-icon">
                    {!! $process['icon'] !!}
                </div>
                <h3 class="ia-card-title">{{ $process['title'] }}</h3>
                <p class="ia-card-desc">{{ $process['desc'] }}</p>
            </article>
            @endforeach
        </div>
    </div>
</section>

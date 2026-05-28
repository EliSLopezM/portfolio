{{-- resources/views/sections/stack.blade.php --}}
<section id="stack" class="section section-light stack-section">

    {{-- Cuadrícula decorativa de fondo --}}
    <div class="stack-grid-bg" aria-hidden="true"></div>

    <div class="container">
        <div class="section-header">
            <span class="section-label">// Stack</span>
            <h2>Tecnologías con las<br><strong>que construyo soluciones</strong></h2>
        </div>

        <div class="stack-grid" id="stackGrid">
            @foreach($portfolio['stack'] as $index => $tech)
            <div class="stack-card {{ $index >= 12 ? 'stack-hidden' : '' }}" data-index="{{ $index }}">
                <div class="stack-card-inner">

                    {{-- Frente --}}
                    <div class="stack-card-front">
                        <div class="stack-icon">
                            {!! $tech['svg'] !!}
                        </div>
                        <span class="stack-name">{{ $tech['name'] }}</span>
                        @if(isset($tech['level']))
                            <span class="stack-badge">Conocimiento</span>
                        @endif
                    </div>

                    {{-- Reverso --}}
                    <div class="stack-card-back">
                        <div class="stack-icon stack-icon-back">
                            {!! $tech['svg'] !!}
                        </div>
                        <span class="stack-name-back">{{ $tech['name'] }}</span>
                        @if(isset($tech['level']))
                            <span class="stack-level">Conocimiento</span>
                        @else
                            <span class="stack-level">Dominio</span>
                        @endif
                        @if(isset($tech['type']))
                            <span style="font-size:0.6rem;color:rgba(255,255,255,0.5);text-align:center;margin-top:2px;">{{ $tech['type'] }}</span>
                        @endif
                    </div>

                </div>
            </div>
            @endforeach
        </div>

        {{-- Botón Ver más / Ver menos --}}
        @if(count($portfolio['stack']) > 12)
        <div class="stack-toggle-wrap">
            <button class="stack-toggle-btn" id="stackToggle" aria-expanded="false">
                <span class="toggle-text">Ver más</span>
                <span class="toggle-icon" aria-hidden="true">
                    <svg class="icon-grid" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"/>
                        <rect x="14" y="3" width="7" height="7"/>
                        <rect x="3" y="14" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/>
                    </svg>
                    <svg class="icon-collapse" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none">
                        <polyline points="18 15 12 9 6 15"/>
                    </svg>
                </span>
            </button>
        </div>
        @endif
    </div>
</section>
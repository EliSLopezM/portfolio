{{-- resources/views/sections/stack.blade.php --}}
<section id="stack" class="section section-light stack-section">

    {{-- Cuadrícula decorativa de fondo --}}
    <div class="stack-grid-bg" aria-hidden="true"></div>

    <div class="container">
        <div class="section-header">
            <span class="section-label">// Stack</span>
            <h2>Tecnologías con las<br><strong>que construyo soluciones</strong></h2>
        </div>

        @php
            $stackGroups = collect($portfolio['stack_categories'])->keyBy('slug');
            $stackByCategory = collect($portfolio['stack'])->groupBy(fn ($tech) => $tech['category'] ?? 'backend');
        @endphp

        <div class="stack-filters" role="group" aria-label="Filtrar tecnologías por nivel">
            <button type="button" class="stack-filter-btn active" data-stack-filter="all">Todos</button>
            <button type="button" class="stack-filter-btn" data-stack-filter="dominio">Dominio</button>
            <button type="button" class="stack-filter-btn" data-stack-filter="conocimiento">En estudio</button>
        </div>

        @foreach($stackGroups as $groupKey => $groupMeta)
            @continue($stackByCategory->get($groupKey, collect())->isEmpty())
            <div class="stack-category {{ $groupMeta['featured'] ? 'stack-category-featured' : '' }}">
                <div class="stack-category-header">
                    <h3 class="stack-category-title">
                        {{ $groupMeta['label'] }}
                        @if($groupMeta['featured'])
                            <span class="stack-favorite-badge">★ Favorito</span>
                        @endif
                    </h3>
                    <p class="stack-category-sub">{{ $groupMeta['sub'] }}</p>
                </div>

                <div class="stack-grid" id="stackGrid-{{ $groupKey }}">
                    @foreach($stackByCategory->get($groupKey) as $index => $tech)
                    <div class="stack-card" data-index="{{ $index }}" data-level="{{ isset($tech['level']) ? 'conocimiento' : 'dominio' }}">
                        <div class="stack-card-inner">

                            {{-- Frente --}}
                            <div class="stack-card-front">
                                <div class="stack-icon">
                                    {!! $tech['svg'] !!}
                                </div>
                                <span class="stack-name">{{ $tech['name'] }}</span>
                                <span class="stack-badge">{{ isset($tech['level']) ? 'En estudio' : 'Dominio' }}</span>
                            </div>

                            {{-- Reverso --}}
                            <div class="stack-card-back">
                                <div class="stack-icon stack-icon-back">
                                    {!! $tech['svg'] !!}
                                </div>
                                <span class="stack-name-back">{{ $tech['name'] }}</span>
                                @if(isset($tech['level']))
                                    <span class="stack-level">En estudio</span>
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
            </div>
        @endforeach
    </div>
</section>
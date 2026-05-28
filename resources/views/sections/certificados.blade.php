{{-- resources/views/sections/certificados.blade.php --}}
@if(!empty($portfolio['certs']))
<section id="certificados" class="section section-light certs-section-wrap">
    <div class="certs-grid-bg" aria-hidden="true"></div>

    <div class="container">
        <div class="section-header">
            <span class="section-label">// Certificados</span>
            <h2>Formación &<br><strong>certificaciones</strong></h2>
        </div>

        {{-- Filtros --}}
        <div class="certs-filters" id="certsFilters">
            <button class="certs-filter-btn active" data-filter="all">Todos</button>
            <button class="certs-filter-btn" data-filter="destacado">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Destacados
            </button>
            <button class="certs-filter-btn" data-filter="curso">Cursos</button>
        </div>

        {{-- Carrusel spotlight --}}
        <div class="certs-spotlight-wrap" id="certsSpotlight">
            @php
                $certsData = json_encode($portfolio['certs']);
            @endphp
            <div class="certs-spotlight-track" id="certsTrack">
                @foreach($portfolio['certs'] as $i => $cert)
                <div class="certs-spotlight-card"
                     data-index="{{ $i }}"
                     data-category="{{ $cert['category'] ?? 'curso' }}"
                     data-pdf="{{ asset('images/certs/' . $cert['pdf']) }}"
                     data-title="{{ $cert['title'] }}">
                    <div class="csc-inner">
                        <div class="csc-img-wrap">
                            @if(!empty($cert['preview']))
                                <img src="{{ asset('images/certs/' . $cert['preview']) }}"
                                     alt="{{ $cert['title'] }}" loading="lazy">
                            @else
                                <div class="csc-placeholder">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="csc-overlay">
                                <button class="csc-open-btn" onclick="openCertModal(this.closest('.certs-spotlight-card'))">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                        <line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/>
                                    </svg>
                                    Ver certificado
                                </button>
                            </div>
                            @if(isset($cert['category']) && $cert['category'] === 'destacado')
                            <div class="csc-badge-star">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                Destacado
                            </div>
                            @endif
                        </div>
                        <div class="csc-body">
                            <span class="csc-platform">{{ $cert['platform'] }}</span>
                            <p class="csc-title">{{ $cert['title'] }}</p>
                            <span class="csc-year">{{ $cert['year'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Navegación --}}
            <button class="csc-nav csc-prev" id="cscPrev" aria-label="Anterior">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button class="csc-nav csc-next" id="cscNext" aria-label="Siguiente">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>

        {{-- Dots --}}
        <div class="csc-dots" id="cscDots"></div>
    </div>
</section>

{{-- Modal PDF --}}
<div class="cert-modal-overlay" id="certModal" role="dialog" aria-modal="true">
    <div class="cert-modal-box">
        <div class="cert-modal-header">
            <span class="cert-modal-title" id="certModalTitle"></span>
            <div class="cert-modal-actions">
                <a class="cert-modal-download" id="certModalDownload" target="_blank" title="Abrir en nueva pestaña">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                        <polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
                    </svg>
                </a>
                <button class="cert-modal-close" id="certModalClose" aria-label="Cerrar">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="cert-modal-body">
            <iframe id="certModalIframe" src="" title="PDF Certificado" allow="fullscreen"></iframe>
        </div>
    </div>
</div>
@endif
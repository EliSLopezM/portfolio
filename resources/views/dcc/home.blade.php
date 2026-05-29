@extends('dcc.layout')
@section('title', 'Defensa Civil — Eli Santiago López')
@section('description', 'Voluntario de la Defensa Civil Colombiana, Comité Bosa Villa Suaita. Gestión de redes sociales y actividades comunitarias.')

@section('content')

{{-- ══ HERO ══ --}}
<section class="dcc-hero">
    <div class="dcc-hero-bg" aria-hidden="true"></div>
    <div class="container dcc-hero-inner">
        <div class="dcc-hero-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
            </svg>
            Voluntario Activo — Defensa Civil Colombiana
        </div>
        <h1 class="dcc-hero-title">
            Sirviendo a la<br>
            <strong>comunidad</strong><br>
            con propósito
        </h1>
        <p class="dcc-hero-sub">
            Comité Bosa Villa Suaita · Bogotá, Colombia<br>
            Gestión de redes sociales · Operaciones de campo · Formación continua
        </p>
        <div class="dcc-hero-actions">
            <a href="#quien-soy" class="dcc-btn dcc-btn-primary">Conocer más ↓</a>
            <a href="{{ route('dcc.contacto') }}" class="dcc-btn dcc-btn-outline">Contacto</a>
        </div>
    </div>
</section>

{{-- ══ ¿QUIÉN SOY? ══ --}}
<section id="quien-soy" class="dcc-section dcc-section-light">
    <div class="dcc-grid-bg" aria-hidden="true"></div>
    <div class="container dcc-section-inner">
        <div class="dcc-section-header">
            <span class="dcc-label">// 01 — Voluntario</span>
            <h2>¿Quién Soy<br><strong>en la DCC?</strong></h2>
        </div>
        <div class="dcc-quien-grid">
            <div class="dcc-quien-text">
                <p>Soy <strong>Eli Santiago López Mahecha</strong>, voluntario activo del <strong>Comité Bosa Villa Suaita</strong> de la Defensa Civil Colombiana, ubicado en la localidad de Bosa, Bogotá.</p>
                <p>Dentro del comité me desempeño como encargado de <strong>redes sociales y comunicaciones</strong>, gestionando la presencia digital del comité en Instagram, Facebook, TikTok y YouTube, con el objetivo de informar a la comunidad sobre actividades, emergencias y prevención.</p>
                <p>Como voluntario de la DCC, mi rol se enmarca en el <strong>Manual del Voluntario vigente</strong>: participar activamente en operaciones de atención de emergencias, capacitaciones técnicas y actividades de prevención y gestión del riesgo de desastres, bajo los principios de humanidad, imparcialidad y voluntariedad.</p>
                <div class="dcc-tags-wrap">
                    <span class="dcc-tag">Redes Sociales</span>
                    <span class="dcc-tag">Gestión del Riesgo</span>
                    <span class="dcc-tag">Comunicaciones</span>
                    <span class="dcc-tag">Trabajo Comunitario</span>
                </div>
            </div>

            {{-- Foto del equipo del comité --}}
            <div class="dcc-equipo-foto-wrap">
                <div class="dcc-equipo-foto-placeholder" id="dccEquipoFoto">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    <p>Foto del equipo<br><span>Comité Bosa Villa Suaita</span></p>
                    {{-- Reemplaza este bloque con: --}}
                    {{-- <img src="{{ asset('images/dcc/equipo.jpg') }}" alt="Equipo Comité Bosa Villa Suaita" class="dcc-equipo-foto"> --}}
                </div>
                <div class="dcc-equipo-badge-wrap">
                    <span class="dcc-equipo-badge">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                        Comité Bosa Villa Suaita
                    </span>
                    <span class="dcc-equipo-badge dcc-equipo-badge-blue">Bogotá, Colombia</span>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="dcc-quien-stats" style="margin-top:48px">
            <div class="dcc-stat-card">
                <div class="dcc-stat-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div class="dcc-stat-val">Comité</div>
                <div class="dcc-stat-lbl">Bosa Villa Suaita</div>
            </div>
            <div class="dcc-stat-card">
                <div class="dcc-stat-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </div>
                <div class="dcc-stat-val">Activo</div>
                <div class="dcc-stat-lbl">Voluntario en formación</div>
            </div>
            <div class="dcc-stat-card">
                <div class="dcc-stat-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="2" y="2" width="20" height="20" rx="5" />
                        <circle cx="12" cy="12" r="5" />
                    </svg>
                </div>
                <div class="dcc-stat-val">4 Redes</div>
                <div class="dcc-stat-lbl">Sociales gestionadas</div>
            </div>
            <div class="dcc-stat-card">
                <div class="dcc-stat-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                        <path d="M6 12v5c3 3 9 3 12 0v-5" />
                    </svg>
                </div>
                <div class="dcc-stat-val">2 Cursos</div>
                <div class="dcc-stat-lbl">En formación activa</div>
            </div>
        </div>
    </div>
</section>

{{-- ══ ¿POR QUÉ LA DCC? ══ --}}
<section id="por-que" class="dcc-section dcc-section-dark">
    <div class="container dcc-section-inner">
        <div class="dcc-section-header dcc-section-header-light">
            <span class="dcc-label dcc-label-light">// 02 — Motivación</span>
            <h2 class="text-light">¿Por qué me<br><strong>gusta la DCC?</strong></h2>
        </div>
        <div class="dcc-porque-grid">
            <div class="dcc-porque-card">
                <div class="dcc-porque-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                    </svg>
                </div>
                <h3>Servicio a la comunidad</h3>
                <p>Más allá del desarrollo de software, siento un compromiso genuino con mi comunidad. La DCC me permite aportar de manera directa a quienes más lo necesitan, especialmente en momentos de emergencia o vulnerabilidad.</p>
            </div>
            <div class="dcc-porque-card">
                <div class="dcc-porque-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                        <path d="M6 12v5c3 3 9 3 12 0v-5" />
                    </svg>
                </div>
                <h3>Aprendizaje constante</h3>
                <p>Actualmente curso <strong>Voluntario en Incendio Forestal</strong> y <strong>Soporte Vital Básico (SVB)</strong>, dos áreas que me permiten adquirir habilidades técnicas reales para responder ante emergencias de forma efectiva y segura.</p>
            </div>
            <div class="dcc-porque-card">
                <div class="dcc-porque-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32" />
                    </svg>
                </div>
                <h3>Impacto real y tangible</h3>
                <p>Cada actividad del comité tiene un impacto medible en la comunidad de Bosa Villa Suaita. Desde simulacros de evacuación hasta jornadas de primeros auxilios, el voluntariado transforma vidas de manera concreta.</p>
            </div>
        </div>
        {{-- Cursos activos --}}
        <div class="dcc-cursos-wrap">
            <h3 class="dcc-cursos-title">Formación en curso</h3>
            <div class="dcc-cursos-grid">
                <div class="dcc-curso-item">
                    <div class="dcc-curso-icon-wrap dcc-curso-fire">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M12 2c0 0-6 5-6 10a6 6 0 0 0 12 0c0-2-1-4-2-5 0 2-1 3-2 3-1 0-2-1-2-3z" fill="rgba(232,112,10,0.2)" />
                            <path d="M9 12c0 0 1-1 2-1s2 1 2 2a2 2 0 0 1-4 0z" />
                        </svg>
                    </div>
                    <div class="dcc-curso-info">
                        <div class="dcc-curso-name">Voluntario en Incendio Forestal</div>
                        <div class="dcc-curso-desc">Técnicas de control, prevención y extinción de incendios forestales</div>
                        <div class="dcc-curso-badge"><span class="dcc-curso-dot"></span>En formación</div>
                    </div>
                </div>
                <div class="dcc-curso-item">
                    <div class="dcc-curso-icon-wrap dcc-curso-svb">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="3" width="18" height="18" rx="3" />
                            <line x1="12" y1="7" x2="12" y2="17" stroke-width="2.5" />
                            <line x1="7" y1="12" x2="17" y2="12" stroke-width="2.5" />
                        </svg>
                    </div>
                    <div class="dcc-curso-info">
                        <div class="dcc-curso-name">Soporte Vital Básico (SVB)</div>
                        <div class="dcc-curso-desc">RCP, manejo de vía aérea y atención de emergencias prehospitalarias</div>
                        <div class="dcc-curso-badge"><span class="dcc-curso-dot"></span>En formación</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ EVENTOS / CALENDARIO ══ --}}
<section id="eventos" class="dcc-section dcc-section-light">
    <div class="dcc-grid-bg" aria-hidden="true"></div>
    <div class="container dcc-section-inner">
        <div class="dcc-section-header">
            <span class="dcc-label">// 03 — Comunidad</span>
            <h2 class="dcc-title-dark">Eventos &<br><strong class="dcc-strong-orange">Redes Sociales</strong></h2>
        </div>

        {{-- Calendario Google --}}
        <div class="dcc-calendar-wrap">
            <div class="dcc-calendar-header">
                <div class="dcc-calendar-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    Calendario de Actividades {{ date('Y') }}
                </div>
                <a href="https://calendar.google.com/calendar/ical/defensacivilbosavillasuaita%40gmail.com/public/basic.ics"
                    target="_blank" rel="noopener" class="dcc-cal-subscribe">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    Suscribirse
                </a>
            </div>
            <div class="dcc-calendar-body">
                <div class="dcc-calendar-embed">
                    <iframe
                        src="https://calendar.google.com/calendar/embed?src=defensacivilbosavillasuaita%40gmail.com&ctz=America%2FBogota&showTitle=0&showNav=1&showDate=1&showPrint=0&showTabs=0&showCalendars=0&showTz=0&mode=MONTH&bgcolor=%23ffffff&color=%23E8700A"
                        style="border:0" width="100%" height="480"
                        frameborder="0" scrolling="no"
                        title="Calendario Defensa Civil Bosa Villa Suaita">
                    </iframe>
                </div>
            </div>
        </div>

        {{-- Blog preview --}}
        @php
        $recentPosts = \App\Models\Post::published()
        ->whereIn('category', ['dcc-evento', 'dcc-informativo'])
        ->limit(3)->get();
        @endphp
        @if($recentPosts->count() > 0)
        <div class="dcc-posts-grid" style="margin-top:48px">
            @foreach($recentPosts as $post)
            <a href="{{ route('dcc.blog.show', $post->slug) }}" class="dcc-post-card">
                @if($post->cover_image)
                <div class="dcc-post-img">
                    <img src="{{ asset('images/' . $post->cover_image) }}" alt="{{ $post->title }}" loading="lazy">
                </div>
                @endif
                <div class="dcc-post-body">
                    <span class="dcc-post-cat">{{ $post->category === 'dcc-evento' ? 'Evento' : 'Informativo' }}</span>
                    <h3>{{ $post->title }}</h3>
                    <p>{{ $post->excerpt }}</p>
                    <span class="dcc-post-date">{{ $post->published_at?->format('d M Y') }}</span>
                </div>
            </a>
            @endforeach
        </div>
        <div class="dcc-blog-cta">
            <a href="{{ route('dcc.blog') }}" class="dcc-btn dcc-btn-primary">Ver todos los eventos →</a>
        </div>
        @endif

        {{-- Redes sociales --}}
        <div class="dcc-redes-wrap">
            <h3 class="dcc-redes-title">Síguenos en redes</h3>
            <div class="dcc-redes-grid">
                <a href="https://www.facebook.com/profile.php?id=61588291684197" target="_blank" rel="noopener" class="dcc-red-card dcc-red-facebook">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                    </svg>
                    <span>Facebook</span><small>defensacivil_bosavillasuaita</small>
                </a>
                <a href="https://www.instagram.com/defensacivil_bosavillasuaita/" target="_blank" rel="noopener" class="dcc-red-card dcc-red-instagram">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="2" y="2" width="20" height="20" rx="5" />
                        <circle cx="12" cy="12" r="5" />
                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                    </svg>
                    <span>Instagram</span><small>@defensacivil_bosavillasuaita</small>
                </a>
                <a href="https://www.tiktok.com/@defensacivilbosavillasua" target="_blank" rel="noopener" class="dcc-red-card dcc-red-tiktok">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.74a4.85 4.85 0 0 1-1.01-.05z" />
                    </svg>
                    <span>TikTok</span><small>@defensacivilbosavillasua</small>
                </a>
                <a href="https://www.youtube.com/@defensacivilbosavillasuaita" target="_blank" rel="noopener" class="dcc-red-card dcc-red-youtube">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                        <rect x="1" y="5" width="22" height="14" rx="3" fill="#FF0000" />
                        <polygon points="9.5,8.5 16.5,12 9.5,15.5" fill="white" />
                    </svg>
                    <span>YouTube</span><small>@defensacivilbosavillasuaita</small>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ══ GALERÍA SPOTLIGHT ══ --}}
<section id="galeria" class="dcc-section dcc-section-dark">
    <div class="container dcc-section-inner">
        <div class="dcc-section-header dcc-section-header-light">
            <span class="dcc-label dcc-label-light">// 04 — Equipo</span>
            <h2 class="text-light">Galería de<br><strong>fotos</strong></h2>
        </div>

        <div class="dcc-gallery-wrap" id="dccGalleryWrap">
            <div class="dcc-gallery-track" id="dccGalleryTrack">
                {{--
          Para agregar fotos reales reemplaza cada item así:
          <div class="dcc-gallery-item" data-index="0">
            <div class="dcc-gallery-inner">
              <img src="{{ asset('images/dcc/foto1.jpg') }}" alt="Actividad DCC" loading="lazy">
                <div class="dcc-gallery-caption">Descripción de la foto</div>
            </div>
        </div>
        --}}
        @for($i = 0; $i < 5; $i++)
            <div class="dcc-gallery-item" data-index="{{ $i }}">
            <div class="dcc-gallery-inner">
                <div class="dcc-gallery-placeholder">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                        <rect x="3" y="3" width="18" height="18" rx="3" />
                        <circle cx="8.5" cy="8.5" r="1.5" />
                        <polyline points="21 15 16 10 5 21" />
                    </svg>
                    <span>Foto {{ $i + 1 }}</span>
                </div>
                <div class="dcc-gallery-caption">Actividad del Comité Bosa Villa Suaita</div>
            </div>
    </div>
    @endfor
    </div>
    <button class="dcc-gallery-nav dcc-gallery-prev" id="dccGalleryPrev">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="15 18 9 12 15 6" />
        </svg>
    </button>
    <button class="dcc-gallery-nav dcc-gallery-next" id="dccGalleryNext">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="9 18 15 12 9 6" />
        </svg>
    </button>
    </div>
    <div class="dcc-gallery-dots" id="dccGalleryDots"></div>

    {{-- Instrucción para agregar fotos --}}
    <p class="dcc-gallery-hint">
        Para agregar fotos reales: sube las imágenes a <code>public/images/dcc/</code> y actualiza el blade.
    </p>
    </div>
</section>

{{-- ══ CTA CONTACTO ══ --}}
<section class="dcc-section dcc-section-light dcc-cta-section">
    <div class="dcc-grid-bg" aria-hidden="true"></div>
    <div class="container dcc-section-inner" style="text-align:center;max-width:600px">
        <div class="dcc-cta-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                <polyline points="22,6 12,13 2,6" />
            </svg>
        </div>
        <h2 class="dcc-title-dark" style="font-size:clamp(1.8rem,3.5vw,2.8rem);font-family:'DM Serif Display',serif;margin-bottom:16px">
            ¿Necesitas<br><strong class="dcc-strong-orange">contactarnos?</strong>
        </h2>
        <p style="color:#666;font-size:1rem;line-height:1.7;margin-bottom:36px">
            Estamos aquí para servir a la comunidad.<br>
            Escríbenos por cualquiera de nuestros canales.
        </p>
        <a href="{{ route('dcc.contacto') }}" class="dcc-btn dcc-btn-primary" style="font-size:1rem;padding:16px 40px">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                <polyline points="22,6 12,13 2,6" />
            </svg>
            Contáctanos
        </a>
    </div>
</section>

@endsection
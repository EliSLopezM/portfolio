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
                <p>Dentro del comité me desempeño como encargado de <strong>redes sociales y comunicaciones</strong>, gestionando la presencia digital del comité en plataformas como Instagram, Facebook, TikTok y YouTube, con el objetivo de informar a la comunidad sobre actividades, emergencias y prevención.</p>
                <p>Como voluntario de la DCC, mi rol se enmarca en el <strong>Manual del Voluntario vigente</strong>: participar activamente en operaciones de atención de emergencias, capacitaciones técnicas y actividades de prevención y gestión del riesgo de desastres, siempre bajo los principios de humanidad, imparcialidad y voluntariedad.</p>
                <div class="dcc-tags-wrap">
                    <span class="dcc-tag">Redes Sociales</span>
                    <span class="dcc-tag">Gestión del Riesgo</span>
                    <span class="dcc-tag">Comunicaciones</span>
                    <span class="dcc-tag">Trabajo Comunitario</span>
                </div>
            </div>
            <div class="dcc-quien-stats">
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
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.19 18.9 19.5 19.5 0 0 1 5.1 12.81 19.79 19.79 0 0 1 2 4.1C2 3 2.7 2.06 3.79 1.74h3a2 2 0 0 1 2 1.72c.127.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91" />
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
                        <div class="dcc-curso-badge">
                            <span class="dcc-curso-dot"></span>
                            En formación
                        </div>
                    </div>
                </div>
                <div class="dcc-curso-item">
                    <div class="dcc-curso-icon-wrap dcc-curso-svb">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="3" width="18" height="18" rx="3" stroke="currentColor" />
                            <line x1="12" y1="7" x2="12" y2="17" stroke="currentColor" stroke-width="2.5" />
                            <line x1="7" y1="12" x2="17" y2="12" stroke="currentColor" stroke-width="2.5" />
                        </svg>
                    </div>
                    <div class="dcc-curso-info">
                        <div class="dcc-curso-name">Soporte Vital Básico (SVB)</div>
                        <div class="dcc-curso-desc">RCP, manejo de vía aérea y atención de emergencias prehospitalarias</div>
                        <div class="dcc-curso-badge">
                            <span class="dcc-curso-dot"></span>
                            En formación
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ EVENTOS / REDES SOCIALES ══ --}}
<section id="eventos" class="dcc-section dcc-section-light">
    <div class="dcc-grid-bg" aria-hidden="true"></div>
    <div class="container dcc-section-inner">
        <div class="dcc-section-header">
            <span class="dcc-label">// 03 — Comunidad</span>
            <h2 class="dcc-title-dark">Eventos &<br><strong class="dcc-strong-orange">Redes Sociales</strong></h2>
        </div>

        {{-- ── Calendario Google ── --}}
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
                <a href="https://calendar.google.com/calendar/r?cid=defensacivilbosavillasuaita@gmail.com"
                    target="_blank" rel="noopener" class="dcc-cal-subscribe">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    Suscribirse
                </a>
            </div>
            <div class="dcc-calendar-body">
                <div class="dcc-calendar-embed">
                    {{-- REEMPLAZA src con tu embed URL de Google Calendar --}}
                    {{-- Instrucciones en: /dcc/contacto#calendario --}}
                    <iframe
                        id="dccCalendarFrame"
                        src="https://calendar.google.com/calendar/embed?src=defensacivilbosavillasuaita%40gmail.com&ctz=America%2FBogota&showTitle=0&showNav=1&showDate=1&showPrint=0&showTabs=0&showCalendars=0&showTz=0&mode=MONTH&color=%23E8700A"
                        style="border:0" width="100%" height="480"
                        frameborder="0" scrolling="no"
                        title="Calendario Defensa Civil Bosa Villa Suaita">
                    </iframe>
                    <div class="dcc-cal-placeholder" id="dccCalPlaceholder">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" style="color:var(--dcc-orange)">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                        <p>El calendario se cargará cuando configures Google Calendar como público.</p>
                        <a href="https://calendar.google.com" target="_blank" class="dcc-btn dcc-btn-outline" style="margin-top:16px;font-size:0.8rem">
                            Ir a Google Calendar →
                        </a>
                    </div>
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
        <div class="dcc-posts-grid">
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
        @else
        <div class="dcc-empty-posts">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" style="color:#E8700A;margin-bottom:16px">
                <rect x="3" y="4" width="18" height="18" rx="2" />
                <line x1="16" y1="2" x2="16" y2="6" />
                <line x1="8" y1="2" x2="8" y2="6" />
                <line x1="3" y1="10" x2="21" y2="10" />
            </svg>
            <p>Próximamente compartiremos eventos y actividades del comité.</p>
            <a href="{{ route('dcc.blog') }}" class="dcc-btn dcc-btn-outline">Ir al Blog</a>
        </div>
        @endif

        {{-- Redes sociales --}}
        <div class="dcc-redes-wrap">
            <h3 class="dcc-redes-title">Síguenos en redes</h3>
            <div class="dcc-redes-grid">
                <a href="https://www.facebook.com/profile.php?id=61588291684197"
                    target="_blank" rel="noopener" class="dcc-red-card dcc-red-facebook">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                    </svg>
                    <span>Facebook</span>
                    <small>defensacivil_bosavillasuaita</small>
                </a>
                <a href="https://www.instagram.com/defensacivil_bosavillasuaita/"
                    target="_blank" rel="noopener" class="dcc-red-card dcc-red-instagram">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="2" y="2" width="20" height="20" rx="5" />
                        <circle cx="12" cy="12" r="5" />
                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                    </svg>
                    <span>Instagram</span>
                    <small>@defensacivil_bosavillasuaita</small>
                </a>
                <a href="https://www.tiktok.com/@defensacivilbosavillasua"
                    target="_blank" rel="noopener" class="dcc-red-card dcc-red-tiktok">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.74a4.85 4.85 0 0 1-1.01-.05z" />
                    </svg>
                    <span>TikTok</span>
                    <small>@defensacivilbosavillasua</small>
                </a>
                <a href="https://www.youtube.com/@defensacivilbosavillasuaita"
                    target="_blank" rel="noopener" class="dcc-red-card dcc-red-youtube">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.97C18.88 4 12 4 12 4s-6.88 0-8.59.45A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58 2.78 2.78 0 0 0 1.95 1.97C5.12 20 12 20 12 20s6.88 0 8.59-.45a2.78 2.78 0 0 0 1.95-1.97A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z" />
                        <polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="white" />
                    </svg>
                    <span>YouTube</span>
                    <small>@defensacivilbosavillasuaita</small>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
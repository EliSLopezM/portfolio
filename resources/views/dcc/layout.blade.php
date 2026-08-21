<!DOCTYPE html>
<html lang="es" data-mode="dcc">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Defensa Civil — Eli Santiago López')</title>
    <meta name="description" content="@yield('description', 'Voluntario Defensa Civil Colombiana — Comité Villa Suaita, Bosa')">

    {{-- OG --}}
    <meta property="og:title" content="@yield('title', 'Defensa Civil — Eli Santiago')">
    <meta property="og:description" content="@yield('description', 'Voluntario DCC Comité Villa Suaita')">
    <meta property="og:type" content="website">

    <link rel="icon" type="image/png" href="{{ asset('elilogo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Mono:wght@400;500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dcc.css') }}">
</head>

<body class="dcc-body">

    {{-- Cursor personalizado (mismo del portfolio) --}}
    <div class="cursor-dot" id="cursorDot"></div>
    <div class="cursor-ring" id="cursorRing"></div>

    {{-- NAV DCC --}}
    <nav class="dcc-nav" id="dccNavbar">
        <a href="{{ route('dcc.index') }}" class="dcc-nav-logo" title="Inicio DCC">
            {{-- Escudo DCC SVG inline hasta tener logo real --}}
            <div class="dcc-shield-icon">
                <svg width="32" height="36" viewBox="0 0 32 36" fill="none">
                    <path d="M16 2L2 8v10c0 9 6.5 15.5 14 17 7.5-1.5 14-8 14-17V8L16 2z" fill="#E8700A" stroke="#fff" stroke-width="1.5" />
                    <path d="M16 8L7 12v7c0 5.5 4 9.5 9 10.5 5-1 9-5 9-10.5v-7L16 8z" fill="#003DA5" />
                    <text x="16" y="21" text-anchor="middle" fill="white" font-size="9" font-weight="bold" font-family="sans-serif">DCC</text>
                </svg>
            </div>
            <div class="dcc-nav-logo-text">
                <span class="dcc-nav-title">Defensa Civil</span>
                <span class="dcc-nav-sub">Bosa — Villa Suaita</span>
            </div>
        </a>

        <ul class="dcc-nav-links" id="dccNavLinks">
            <li>
                <a href="{{ route('dcc.index') }}#quien-soy"
                    class="dcc-nav-link {{ request()->routeIs('dcc.index') ? 'active' : '' }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    ¿Quién Soy?
                </a>
            </li>
            <li>
                <a href="{{ route('dcc.index') }}#por-que"
                    class="dcc-nav-link {{ request()->routeIs('dcc.index') ? 'active' : '' }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                    </svg>
                    ¿Por qué la DCC?
                </a>
            </li>
            <li>
                <a href="{{ route('dcc.index') }}#eventos"
                    class="dcc-nav-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    Eventos
                </a>
            </li>
            <li>
                <a href="https://www.defensacivil.gov.co" target="_blank" rel="noopener"
                    class="dcc-nav-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="2" y1="12" x2="22" y2="12" />
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                    </svg>
                    Defensa Civil ↗
                </a>
            </li>
            <li>
                <a href="{{ route('dcc.blog') }}"
                    class="dcc-nav-link {{ request()->routeIs('dcc.blog*') ? 'active' : '' }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    Blog
                </a>
            </li>
            <li>
                <a href="{{ route('dcc.contacto') }}"
                    class="dcc-nav-link {{ request()->routeIs('dcc.contacto') ? 'active' : '' }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                    Contacto
                </a>
            </li>
        </ul>

        <button class="dcc-nav-toggle" id="dccNavToggle" aria-label="Menú">
            <span></span><span></span><span></span>
        </button>

    </nav>

    <main>@yield('content')</main>

    @include('partials.footer')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/dcc.js') }}"></script>
</body>

</html>
@extends('dcc.layout')
@section('title', 'Contacto — DCC Bosa Villa Suaita')
@section('content')
<section class="dcc-section dcc-section-light" style="padding-top:120px">
    <div class="dcc-grid-bg" aria-hidden="true"></div>
    <div class="container dcc-section-inner" style="max-width:700px">
        <div class="dcc-section-header">
            <span class="dcc-label">// Contacto</span>
            <h1 class="dcc-title-dark">¿Necesitas<br><strong class="dcc-strong-orange">contactarnos?</strong></h1>
            <p style="color:#555;margin-top:16px;font-size:1rem">
                Puedes comunicarte con nosotros a través de nuestras redes sociales o por correo electrónico.
                Respondemos en el menor tiempo posible.
            </p>
        </div>

        {{-- Email destacado --}}
        <a href="mailto:defensacivilbosavillasuaita@gmail.com" class="dcc-contact-email">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                <polyline points="22,6 12,13 2,6" />
            </svg>
            defensacivilbosavillasuaita@gmail.com
        </a>

        {{-- Redes --}}
        <div class="dcc-redes-grid" style="margin-top:40px">
            <a href="https://www.facebook.com/profile.php?id=61588291684197"
                target="_blank" rel="noopener" class="dcc-red-card dcc-red-facebook">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                </svg>
                <span>Facebook</span>
                <small>Defensa Civil Bosa Villa Suaita</small>
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
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                    <rect x="1" y="5" width="22" height="14" rx="3" fill="#FF0000" />
                    <polygon points="9.5,8.5 16.5,12 9.5,15.5" fill="white" />
                </svg>
                <span>YouTube</span>
                <small>@defensacivilbosavillasuaita</small>
            </a>
        </div>
    </div>
</section>
@endsection
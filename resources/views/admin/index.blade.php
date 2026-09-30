@extends('admin.layout')
@section('title', 'Inicio')
@section('content')
<div class="head"><div><h1>Hola, {{ auth()->user()->name }}</h1><p class="muted">Elige qué sitio quieres administrar.</p></div></div>
<div class="hub">
  <a class="card" href="{{ route('admin.develop.home') }}">
    <h2>Admin · Develop</h2>
    <p class="muted">Portafolio profesional: blogs, imágenes, enlaces, cifras, tecnologías, trabajo real, certificados y mensajes de contacto.</p>
    <p style="margin-top:1rem"><span class="pill">{{ $devPosts }} blogs</span> <span class="pill {{ $unread ? 'on' : '' }}">{{ $unread }} mensajes sin leer</span></p>
  </a>
  <a class="card" href="{{ route('admin.dcc.home') }}">
    <h2>Admin · DCC</h2>
    <p class="muted">Defensa Civil Bosa Villa Suaita: blogs, galería de imágenes y calendario de fechas especiales y reuniones.</p>
    <p style="margin-top:1rem"><span class="pill">{{ $dccPosts }} blogs</span></p>
  </a>
</div>
@endsection

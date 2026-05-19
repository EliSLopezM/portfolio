@extends('layouts.app')

@section('content')
  @include('sections.hero',       ['portfolio' => $portfolio])
  @include('sections.sobre',      ['portfolio' => $portfolio])
  @include('sections.stack',      ['portfolio' => $portfolio])
  @include('sections.proyectos',  ['portfolio' => $portfolio])
  @include('sections.experiencia',['portfolio' => $portfolio])
  @include('sections.contacto',   ['portfolio' => $portfolio])
@endsection

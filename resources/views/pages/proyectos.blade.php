@extends('layouts.app')
@section('content')
  @include('sections.proyectos', ['portfolio' => $portfolio])
@endsection

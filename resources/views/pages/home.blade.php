@extends('layouts.app')
@section('content')
  @include('sections.hero', ['portfolio' => $portfolio])
  @include('sections.sobre', ['portfolio' => $portfolio])
@endsection

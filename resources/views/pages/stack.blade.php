@extends('layouts.app')
@section('content')
  @include('sections.stack', ['portfolio' => $portfolio])
@endsection

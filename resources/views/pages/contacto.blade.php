@extends('layouts.app')
@section('content')
  @include('contact.index', ['portfolio' => $portfolio])
@endsection

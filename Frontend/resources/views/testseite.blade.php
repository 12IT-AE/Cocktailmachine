@extends('layouts.app')

@section('title', 'Create Recipe')
@section('content')

@foreach ($glasses as $glass)
{{ $glass->name }}
@endforeach

@endsection
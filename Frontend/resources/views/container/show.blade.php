@extends('layouts.app')

@section('title', 'Show Container')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1>{{ $container->liquid->name }}</h1>
        </div>
        <div class="card-body">
            <p class="card-text">Volume: {{ $container->volume }} ml</p>
            <p class="card-text">Current Volume: {{ $container->current_volume }} ml</p>
            
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Show Recipe')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1>{{ $liquid->name }}</h1>
        </div>
        <div class="card-body">
            <p class="card-text">Color: {{ $liquid->color }}</p>
            <p class="card-text">Alcoholic: {{ $liquid->alcoholic ? 'Yes' : 'No' }}</p>
            <p class="card-text">Volumen: {{ $liquid->volume_percent }}</p>
        </div>
    </div>
</div>
@endsection
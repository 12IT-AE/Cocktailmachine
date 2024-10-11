@extends('layouts.app')

@section('title', 'Show Recipe')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1>{{ $garnish->name }}</h1>
        </div>
        <div class="card-body">
            <p class="card-text">Color: {{ $garnish->color }}</p>
            <p class="card-text">Alcoholic: {{ $garnish->alcoholic ? 'Yes' : 'No' }}</p>
        </div>
    </div>
</div>
@endsection
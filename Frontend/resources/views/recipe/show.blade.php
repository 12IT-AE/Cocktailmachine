@extends('layout.app')

@section('title', 'Show Recipe')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1>{{ $recipe->name }}</h1>
        </div>
        <div class="card-body">
            <p class="card-text">{{ $recipe->description }}</p>
            <h2>Ingredients</h2>
            <ul class="list-group">
                @foreach ($recipe->ingredients as $ingredient)
                    <li class="list-group-item">{{ $ingredient->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
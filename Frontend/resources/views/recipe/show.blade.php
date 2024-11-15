@extends('layouts.app')

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
                    <li>{{ $ingredient->liquid->name }}</li>
                @endforeach
            </ul>
            <h2>Garnishes</h2>
            <ul class="list-group">
                @foreach($recipe->garnishes as $garnish)
                    <li>{{ $garnish->name }}</li>
                @endforeach
            </ul>
            <h2>Gläser</h2>
            <ul class="list-group">
                <li>{{ $recipe->glass}}</li>
            </ul>
        </div>
    </div>
</div>
@endsection
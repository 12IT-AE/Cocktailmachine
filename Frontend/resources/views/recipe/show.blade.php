@extends('layouts.app')

@section('title', 'Show Recipe')
@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1>{{ $recipe->name }}</h1>
            <div>
                <a href="{{ route('recipe.edit', $recipe->id) }}" class="btn btn-warning mr-2">Edit</a>
                <form action="{{ route('recipe.destroy', $recipe->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this recipe?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset($recipe->image) }}" class="img-fluid rounded mb-3" alt="{{ $recipe->name }}">
                </div>
                <div class="col-md-8">
                    <p class="card-text">{{ $recipe->description }}</p>
                    <h2>Zutaten</h2>
                    <ul class="list-group mb-3">
                        @foreach ($recipe->ingredients as $ingredient)
                        <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color: {{ $ingredient->liquid->color }}; background-color: rgba({{ hexdec(substr($ingredient->liquid->color, 1, 2)) }}, {{ hexdec(substr($ingredient->liquid->color, 3, 2)) }}, {{ hexdec(substr($ingredient->liquid->color, 5, 2)) }}, 0.5);">
                        {{ $ingredient->liquid->name }}
                                <span class="badge badge-primary badge-pill">{{ $ingredient->amount }} ml</span>
                            </li>
                        @endforeach
                    </ul>
                    <h2>Garnierungen</h2>
                    <ul class="list-group mb-3">
                        @foreach($recipe->garnishes as $garnish)
                            <li class="list-group-item">{{ $garnish->name }}</li>
                        @endforeach
                    </ul>
                    <h2>Glass</h2>
                    <x-glass-media :glass="$recipe->glass" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

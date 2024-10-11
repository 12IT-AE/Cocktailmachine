@extends('layouts.app')

@section('content')

<div class="container">
    <x-create-button model="recipe" />

    <div class="row">
        @foreach($recipes as $recipe)
            <div class="col-4">
                <div class="card mt-3">
                    <div class="card-header">
                        <h3>Recipe: {{ $recipe->name }}</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Description: {{ $recipe->description }}</p>
                        <p class="card-text">Ingredients:</p>
                        <ul>
                            @foreach($recipe->ingredients as $ingredient)
                                <li>{{ $ingredient->name }} - {{ $ingredient->pivot->quantity }} ml</li>
                            @endforeach
                        </ul>
                        <a href="{{ route('recipe.show', $recipe->id) }}" class="btn btn-primary">Ansehen</a>
                        <a href="{{ route('recipe.edit', $recipe->id) }}" class="btn btn-warning">Bearbeiten</a>
                        <form action="{{ route('recipe.destroy', $recipe->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Löschen</button>
                        </form>                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
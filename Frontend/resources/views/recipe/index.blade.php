@extends('layouts.app')

@section('content')

<div class="container">
    <x-create-button model="recipe" />

    <div class="row">
        @foreach($recipes as $recipe)
        <div class="col-md-12 col-lg-4">
            <x-card :title="'Rezept: '.$recipe->name"  :id="$recipe->id">
                <p class="card-text">Beschreibung: {{ $recipe->description }}</p>
                <p class="card-text">Ingredients:</p>
                <ul>
                    @foreach($recipe->ingredients as $ingredient)
                        <li>{{ $ingredient->liquid->name }} - {{ $ingredient->amount }} ml</li>
                    @endforeach
                </ul>
            </x-card>
        </div>
        @endforeach
    </div>
</div>

@endsection
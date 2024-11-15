@extends('layouts.app')

@section('title', 'Rezepte')
@section('content')

<div class="container">
    <x-create-button model="recipe" />

    <div class="row">
        @foreach($recipes as $recipe)
        <div class="col-md-12 col-lg-4">
            <x-recipe-card :recipe="$recipe" />
        </div>
        @endforeach
    </div>
</div>

@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Recipe</h1>
    <form action="{{ route('recipe.update', $recipe->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Recipe Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $recipe->name }}" required>
        </div>

        <div class="form-group">
            <label for="glass_id">Glass</label>
            <select class="form-control" id="glass_id" name="glass_id">
            @foreach($glasses as $glass)
                <option value="{{ $glass->id }}" {{ $glass->id == $recipe->glass_id ? 'selected' : '' }}>
                {{ $glass->name }}
                </option>
            @endforeach
            </select>

        @foreach($recipe->ingredients as $ingredient)
        <div class="form-group">
            <label for="ingredient_{{ $loop->index }}">Ingredient {{ $loop->iteration }}</label>
            <select class="form-control" id="ingredient_{{ $loop->index }}" name="ingredients[]">
            @foreach($allIngredients as $option)
                <option value="{{ $option->id }}" {{ $option->id == $ingredient->id ? 'selected' : '' }}>
                {{ $option->name }}
                </option>
            @endforeach
            </select>
        </div>
        @endforeach

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5">{{ $recipe->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="ice">Include Ice</label>
            <select class="form-control" id="ice" name="ice">
            <option value="1" {{ $recipe->ice ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$recipe->ice ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Recipe</button>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Recipe</h2>
    <form action="{{ route('recipe.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <div class="form-group">
                    <label for="name">Recipe Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $recipe->name }}" required>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="form-group">
                    <label for="glass_id">Glass</label>
                    <select class="form-control" id="glass_id" name="glass_id">
                        @foreach($glasses as $glass)
                            <option value="{{ $glass->id }}" {{ $glass->id == $recipe->glass_id ? 'selected' : '' }}>
                                {{ $glass->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ $recipe->description }}</textarea>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Ingredients</label><br>
            <button type="button" class="btn btn-secondary mt-2" id="add-ingredient">Add Ingredient</button>
            <div id="ingredients-container">
                @foreach($recipe->ingredients as $ingredient)
                    <x-liquid-input :liquids="$liquids" :ingredient="$ingredient" />
                @endforeach
            </div>
        </div>

        <template id="liquid-input-template">
            <x-liquid-input :liquids="$liquids" />
        </template>

        <div class="form-group">
            <label>Garnishes</label><br>
            <button type="button" class="btn btn-secondary mt-2" id="add-garnish">Add Garnish</button>
            <div id="garnishes-container">
                @foreach($recipe->garnishes as $garnish)
                    <x-garnish-input :garnishes="$garnishes" :garnish="$garnish" />
                @endforeach
            </div>
        </div>

        <template id="garnish-input-template">
            <x-garnish-input :garnishes="$garnishes" />
        </template>

        <div class="form-group">
            <label for="ice">Include Ice</label>
            <select class="form-control" id="ice" name="ice">
                <option value="1" {{ $recipe->ice ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$recipe->ice ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ingredientsContainer = document.getElementById('ingredients-container');
        const addIngredientButton = document.getElementById('add-ingredient');
        const liquidInputTemplate = document.getElementById('liquid-input-template').innerHTML;

        addIngredientButton.addEventListener('click', function() {
            const newLiquidInput = document.createElement('div');
            newLiquidInput.innerHTML = liquidInputTemplate;
            ingredientsContainer.appendChild(newLiquidInput);
        });

        ingredientsContainer.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-liquid')) {
                event.target.closest('.liquid-input').remove();
            }
        });

        const garnishesContainer = document.getElementById('garnishes-container');
        const addGarnishButton = document.getElementById('add-garnish');
        const garnishInputTemplate = document.getElementById('garnish-input-template').innerHTML;

        addGarnishButton.addEventListener('click', function() {
            const newGarnishInput = document.createElement('div');
            newGarnishInput.innerHTML = garnishInputTemplate;
            garnishesContainer.appendChild(newGarnishInput);
        });

        garnishesContainer.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-garnish')) {
                event.target.closest('.garnish-input').remove();
            }
        });
    });
</script>
@endsection
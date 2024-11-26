@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Create Recipe</h2>
        <form action="{{ route('recipe.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="form-group">
                        <label for="glass_id">Glas</label>
                        <select class="form-control" id="glass_id" name="glass_id">
                            @foreach ($glasses as $glass)
                                <option value="{{ $glass->id }}">{{ $glass->name }} ({{ $glass->volume }} ml)</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="form-group">
                        <label for="description">Beschreibung</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Zutaten</label><br>
                <button type="button" class="btn btn-secondary mt-2" id="add-ingredient">Zutat Hinzufügen</button>
                <div id="ingredients-container">
                    <x-liquid-input :liquids="$liquids" />
                </div>
            </div>

            <template id="liquid-input-template">
                <x-liquid-input :liquids="$liquids" />
            </template>

            <div class="form-group">
                <label>Garnierungen</label><br>
                <button type="button" class="btn btn-secondary mt-2" id="add-garnish">Garnierung Hinzufügen</button>
                <div id="garnishes-container">
                </div>
            </div>

            <template id="garnish-input-template">
                <x-garnish-input :garnishes="$garnishes" />
            </template>

            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div class="form-group">
                        <label for="ice">Eis</label>
                        <select class="form-control" id="ice" name="ice">
                            <option value="1">Ja</option>
                            <option value="0">Nein</option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label for="image">Bild</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
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

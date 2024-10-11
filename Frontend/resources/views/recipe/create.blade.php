@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Rezept Erstellen</h2>
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
                            <option value="0">Keins</option>
                            @foreach ($glasses as $glass)
                                <option value="{{ $glass->id }}">{{ $glass->name }}</option>
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
                <div id="ingredients-container"></div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    let liquidCount = 0;
                    const ingredientsContainer = document.getElementById('ingredients-container');
                    const addIngredientButton = document.getElementById('add-ingredient');

                    addIngredientButton.addEventListener('click', function() {
                        liquidCount++;
                        const liquidDiv = document.createElement('div');
                        liquidDiv.classList.add('form-group', 'mt-2');
                        liquidDiv.innerHTML = `
                    <div class='row'>
                        <div class='col-4'>
                            <label for="liquid">Flüssigkeit</label>
                            <select class="form-control" id="liquid" name="liquids[]">
                                @foreach ($liquids as $liquid)
                                    <option value="{{ $liquid->id }}">{{ $liquid->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class='col-2'>
                            <label for="amount" class="">Menge (ml)</label>
                            <input type="number" class="form-control" id="amount" name="amounts[]" value="50">
                        </div>
                        <div class='col-2 d-flex align-items-end'>
                            <button type="button" class="btn btn-danger remove-ingredient">Entfernen</button>
                        </div>
                    </div>
                    `;
                        ingredientsContainer.appendChild(liquidDiv);
                    });
                });
            </script>
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
            <button type="submit" class="btn btn-primary">Erstellen</button>
        </form>
    </div>
    <script>
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-ingredient')) {
                e.target.closest('.form-group').remove();
            }
        });
    </script>
@endsection

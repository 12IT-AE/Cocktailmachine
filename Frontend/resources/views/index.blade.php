@extends('layouts.app')

@section('title', 'Create Recipe')
@section('content')
<form action="{{ route('recipes.store') }}" method="POST">
    @csrf
    <div>
        <label for="name">Recipe Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div>
        <label for="ingredients">Ingredients:</label>
        <textarea id="ingredients" name="ingredients" required></textarea>
    </div>
    <div>
        <label for="description">Instructions:</label>
        <textarea id="description" name="description" required></textarea>
    </div>
    <button type="submit">Create Recipe</button>
</form>
@endsection

@pushOnce('scripts')
    <script> </script>
@endPushOnce
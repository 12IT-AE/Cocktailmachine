@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Create Glass</h2>
    <form action="{{ route('glass.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="volume">Größe (ml)</label>
            <input type="number" class="form-control" id="volume" name="volume" required>
        </div>
        <div class="form-group">
            <label for="image">Bild</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New garnish</h2>
    <form action="{{ route('garnish.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="instructions">Instructions:</label>
            <textarea class="form-control" id="instructions" name="instructions" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
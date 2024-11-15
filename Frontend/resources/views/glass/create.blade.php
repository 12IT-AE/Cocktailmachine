@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Create Glass</h2>
    <form action="{{ route('glass.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="volume">Volume</label>
            <input type="number" class="form-control" id="volume" name="volume" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
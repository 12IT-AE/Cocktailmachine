@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Create Recipe</h2>
    <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="glass_id">Glass</label>
            <select class="form-control" id="glass_id" name="glass_id">
                <option value="0">None</option>
                @foreach($glasses as $glass)
                    <option value="{{ $glass->id }}">{{ $glass->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="ice">Ice</label>
            <select class="form-control" id="ice" name="ice">
            <option value="1">True</option>
            <option value="0">False</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Liquid</h2>
    <form action="{{ route('liquid.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="color">Color:</label>
            <input type="color" class="form-control" id="color" name="color" required>
        </div>
        <div class="form-group">
            <label for="alcoholic">Alcoholic:</label>
            <select class="form-control" id="alcoholic" name="alcoholic" required>
            <option value="1">True</option>
            <option value="0">False</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Container</h2>
    <form action="{{ route('container.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="liquid">Liquid:</label>
            <select class="form-control" id="liquid" name="liquid_id" required>
                @foreach($liquids as $liquid)
                    <option value="{{ $liquid->id }}">{{ $liquid->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="volume">Volumen (ml):</label>
            <input type="number" class="form-control" id="volume" name="volume" value="{{ old('volume', 1000) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
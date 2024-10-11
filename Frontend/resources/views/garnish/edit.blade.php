@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit garnish</h1>
        <form action="{{ route('garnish.update', $garnish->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-input type="text" name="name" id="name" label="Name" value="{{ $garnish->name }}" required />

            <x-input type="text" name="alternative_name" id="alternative_name" label="Alternativ Name"
                value="{{ $garnish->alternative_name }}" />
            <x-input type="color" name="color" id="color" label="Farbe" value="{{ $garnish->color }}" required />
            <button type="submit" class="btn btn-primary">Update garnish</button>
        </form>
    </div>
@endsection

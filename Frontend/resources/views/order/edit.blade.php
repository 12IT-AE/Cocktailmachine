@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Liquid</h1>
        <form method="POST">
            @csrf
            @method('PUT')

            <x-input type="text" name="name" id="name" label="Name" required />

            <x-input type="text" name="alternative_name" id="alternative_name" label="Alternativ Name"/>
            <x-input type="color" name="color" id="color" label="Farbe" required />
            <button type="submit" class="btn btn-primary">Update Liquid</button>
        </form>
    </div>
@endsection

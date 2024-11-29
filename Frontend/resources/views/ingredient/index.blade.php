@extends('layouts.app')

@section('content')

<div class="container">
    <x-create-button model="ingredient" />
    <div class="row">
        @foreach($ingredients as $ingredient)
        <div class="col-md-12 col-lg-4">
            <x-card :title="$ingredient->liquid->name"  :id="$ingredient->id">
                <p class="card-text">Rezept: {{ $ingredient->recipe->name }}</p>
                <p class="card-text">Menge: {{ $ingredient->amount }} ml</p>
                <p class="card-text">Volumen: {{ $ingredient->volume_percent }}</p>
            </x-card>
        </div>
        @endforeach
    </div>
</div>

@endsection
@extends('layouts.app')

@section('content')

<div class="container">
    <x-create-button model="glass" />

    <div class="row">
        @foreach($glasses as $glass)
        <div class="col-md-12 col-lg-4">
            <x-card :title="$glass->name"  :id="$glass->id">
                <p class="card-text">Beschreibung: {{ $glass->description }}</p>
            </x-card>
        </div>
        @endforeach
    </div>
</div>

@endsection
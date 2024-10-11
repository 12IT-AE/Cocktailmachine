@extends('layouts.app')

@section('content')
    <div class="container">
        <x-create-button model="garnish" />
        <div class="row">
            @foreach ($garnishes as $garnish)
                <div class="col-md-12 col-lg-4">
                    <x-card :title="$garnish->name" :subtitle="$garnish->alternative_name" :id="$garnish->id">
                        <p class="card-text">Beschreibung: {{ $garnish->description }}</p>
                    </x-card>
                </div>
            @endforeach
        </div>
    </div>
@endsection

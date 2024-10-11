@extends('layouts.app')

@section('content')
    <div class="container">
        <x-create-button model="liquid" />
        <div class="row">
            @foreach ($liquids as $liquid)
                <div class="col-md-12 col-lg-4">
                    <x-card :title="$liquid->name" :subtitle="$liquid->alternative_name" :id="$liquid->id">
                        <p class="card-text">Beschreibung: {{ $liquid->description }}</p>
                    </x-card>
                </div>
            @endforeach
        </div>
    </div>
@endsection

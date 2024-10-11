@extends('layouts.app')

@section('content')

<div class="container">
    <x-create-button model="container" />

    <div class="row">
        @foreach($containers as $container)
        <div class="col-md-12 col-lg-4">
            <x-card :title="'Container - ' . $container->id" :subtitle="'Flüssigkeit: '.$container->liquid->name" :id="$container->id">
                <p class="card-text">Volume: {{ $container->volume }} ml</p>
                <p class="card-text">Current Volume: {{ $container->current_volume }} ml</p>
            </x-card>
        </div>
        @endforeach
    </div>
</div>

@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <x-create-button model="pump" />
        <div class="row">
            @foreach ($pumps as $pump)
                <div class="col-md-12 col-lg-4">
                    <x-card :title="'Pumpe: ' . $pump->name" :subtitle="'Container: ' . $pump->container->liquid->name" :id="$pump->id">
                        <p class="card-text">Volume: {{ $pump->container->volume }} ml</p>
                        <p class="card-text">Current Volume: {{ $pump->container->current_volume }} ml</p>
                    </x-card>
                </div>
            @endforeach
        </div>
    @endsection

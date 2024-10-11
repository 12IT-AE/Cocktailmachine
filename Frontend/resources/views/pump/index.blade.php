@extends('layouts.app')

@section('content')

<div class="container">
    <x-create-button model="pump" />

    <div class="row">
        @foreach($pumps as $pump)
            <div class="col-4">
                <div class="card mt-3">
                    <div class="card-header">
                        <h3>Pumpe: {{ $pump->id }}</h3>
                        <sub>Container: {{ $pump->container->liquid->name }}</sub>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Volume: {{ $pump->container->volume }} ml</p>
                        <p class="card-text">Current Volume: {{ $pump->container->current_volume }} ml</p>
                        <a href="{{ route('pump.show', $pump->id) }}" class="btn btn-primary">Show</a>
                        <a href="{{ route('pump.edit', $pump->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('pump.destroy', $pump->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
</div>
@endsection
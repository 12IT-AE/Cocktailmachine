@extends('layouts.app')

@section('content')

<div class="container">
    <x-create-button model="container" />

    <div class="row">
        @foreach($containers as $container)
            <div class="col-4">
                <div class="card mt-3">
                    <div class="card-header">
                        <h3>Container: {{ $container->id }} - {{ $container->liquid->name }}</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Volume: {{ $container->volume }} ml</p>
                        <p class="card-text">Current Volume: {{ $container->current_volume }} ml</p>
                        <a href="{{ route('container.show', $container->id) }}" class="btn btn-primary">Show</a>
                        <a href="{{ route('container.edit', $container->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('container.destroy', $container->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection

@extends('layouts.app')

@section('content')

<div class="container">
    <x-create-button model="liquid" />

    <div class="row">
        @foreach($liquids as $liquid)
            <div class="col-4">
                <div class="card mt-3">
                    <div class="card-header">
                        <h3>{{ $liquid->name }}</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Beschreibung: {{ $liquid->description }}</p>
                        <a href="{{ route('liquid.show', $liquid->id) }}" class="btn btn-primary">Ansehen</a>
                        <a href="{{ route('liquid.edit', $liquid->id) }}" class="btn btn-warning">Bearbeiten</a>
                        <form action="{{ route('liquid.destroy', $liquid->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Löschen</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

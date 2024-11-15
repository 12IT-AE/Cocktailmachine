@extends('layouts.app')

@section('content')

<div class="container">
    <x-create-button model="glass" />

    <div class="row">
        @foreach($glasses as $glass)
        <div class="col-md-4 mb-4">
            <a href="{{ route('glass.show', $glass->id) }}" class="text-decoration-none">
                <x-glass-media :glass="$glass" />
            </a>
        </div>
        @endforeach
    </div>
</div>

@endsection
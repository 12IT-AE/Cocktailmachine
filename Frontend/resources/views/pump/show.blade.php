@extends('layouts.app')

@section('title', 'Show Pump')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1>Pump Details</h1>
        </div>
        <div class="card-body">
            <p class="card-text">Container: {{ $pump->container->name }}</p>
            <p class="card-text">Pin: {{ $pump->pin }}</p>
            <a href="{{ route('pump.edit', $pump->id) }}" class="btn btn-primary">Edit Pump</a>
        </div>
    </div>
</div>
@endsection
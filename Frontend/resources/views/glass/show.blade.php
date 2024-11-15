@extends('layouts.app')

@section('title', 'Show Recipe')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1>{{ $glass->name }}</h1>
        </div>
        <div class="card-body">
            <p class="card-text">Glas Menge: {{ $glass->volume }}</p>
            
            
        </div>
    </div>
</div>
@endsection
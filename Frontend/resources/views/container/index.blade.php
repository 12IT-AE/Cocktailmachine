@extends('layouts.app')

@section('content')

<div class="container">
    <x-create-button model="container" />

    <div class="row">
        @foreach($containers as $container)
        <div class="col-md-12 col-lg-4">
            <x-container-card :container="$container" />
        </div>  
        @endforeach
    </div>
</div>

@endsection

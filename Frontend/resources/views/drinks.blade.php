@extends('layout.app')

@section('content')
<div class="text-center mb-4">
    <h1>DrinkPad '24</h1>
</div>
<div class="row">
    @foreach(['Mojito', 'Bloody Mary', 'Sex on the Beach'] as $drink)
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <img src="{{ asset('images/' . strtolower(str_replace(' ', '_', $drink)) . '.png') }}" class="card-img-top" alt="{{ $drink }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $drink }}</h5>
                    <a href="#" class="btn btn-produce">Produzieren</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

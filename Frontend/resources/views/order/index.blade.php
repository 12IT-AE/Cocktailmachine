@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="order_h" style="font-size: 70px; text-align:center;">DrinkPad</h1>
        <div style="width: 100%;">
            @foreach($recipes as $recipe)
                <div data-bs-toggle="modal" data-bs-target="#modal-{{ $recipe->id }}" class="orderElement">
                    <div class="imageBlock">
                        <img class="cooktailImg" style=" width: 100%; height: 100%; object-fit: cover; object-position: center; border-radius: 10px" src="{{ asset($recipe->image) }}" alt="">
                    </div>
                    <div class="infoBlock">
                        {{$recipe->name}}
                    </div>
                </div>
                @include('order.modal')
            @endforeach
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>DrinkPad</h1>
        <div style="width: 100%;">

            <a href="{{route("recipe.show", 1)}}" class="orderElement">
                <div class="imageBlock">
                    <img class="cooktailImg" src={{asset("images/mojito.png")}} alt="">
                </div>
                <div class="infoBlock">
                    Mojito
                </div>
            </a>
            <div class="orderElement">
                <div class="imageBlock">
                    <img class="cooktailImg" src={{asset("images/bloody_mary.png")}} alt="">
                </div>
                <div class="infoBlock">
                    Bloody Mary
                </div>
            </div>
            <div class="orderElement">
                <div class="imageBlock">
                    <img class="cooktailImg" src={{asset("images/sex_on_the_beach.png")}} alt="">
                </div>
                <div class="infoBlock">
                    Sex on the Beach
                </div>
            </div>
            <div class="orderElement">
                <div class="imageBlock">
                    <img class="cooktailImg" src={{asset("images/mojito.png")}} alt="">
                </div>
                <div class="infoBlock">
                    Mojito
                </div>
            </div>
            <div class="orderElement">
                <div class="imageBlock">
                    <img class="cooktailImg" src={{asset("images/mojito.png")}} alt="">
                </div>
                <div class="infoBlock">
                    Mojito
                </div>
            </div>
            <div class="orderElement">
                <div class="imageBlock">
                    <img class="cooktailImg" src={{asset("images/mojito.png")}} alt="">
                </div>
                <div class="infoBlock">
                    Mojito
                </div>
            </div>
        </div>
    </div>
        <!-- Div Trigger -->
        <div class="trigger-div" data-bs-toggle="modal" data-bs-target="#modal-xl">
            Klicke hier, um das Modal zu öffnen
        </div>

        <!-- Modal einbinden -->
        @include('recipe.modal')
    
    {{-- <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-xl">
        modal-xl
      </button>
    
      <x-modal id="modal-xl" title="Modal XL" size="xl">
        <x-slot name="body">
          Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
        </x-slot>
        <x-slot name="footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </x-slot>
      </x-modal> --}}

@endsection

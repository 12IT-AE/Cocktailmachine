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
@endsection

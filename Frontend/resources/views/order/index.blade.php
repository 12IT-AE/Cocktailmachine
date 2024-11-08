@extends('layouts.app')

@section('content')
    <div class="container">
        <div style="width: 100%;">
            <div class="orderElement">
                <div class="imageBlock">
                    <img src="" alt="">
                </div>
                <div class="infoBlock">
                    Continental Sour & New York Sour
                </div>
            </div>

            <div class="orderElement">
                <div class="imageBlock">
                    <img src="" alt="">
                </div>
                <div class="infoBlock">
                    Continental Sour
                </div>
            </div>







            <div class="orderElement">Test</div>
            <div class="orderElement">Test</div>
            <div class="orderElement">Test</div>
            <div class="orderElement">Test</div>
            <div class="orderElement">Test</div>
            <div class="orderElement">Test</div>
        </div>

        <x-create-button model="order" />
        <div class="row">
            Test12
        </div>
    </div>
@endsection

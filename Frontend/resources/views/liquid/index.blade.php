@extends('layouts.app')

@section('content')
    <div class="container">
        <x-create-button model="liquid" />
        <div class="row">
            @foreach ($liquids as $liquid)
            <div class="col-md-12 col-lg-4">
                    <x-liquid-card :liquid="$liquid" />
                </div>
            @endforeach
        </div>
    </div>
@endsection

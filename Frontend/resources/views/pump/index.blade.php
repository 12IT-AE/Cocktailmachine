@extends('layouts.app')

@section('content')
    <div class="container">
        <x-create-button model="pump" />
        <div class="row">
            @foreach ($pumps as $pump)
                <div class="col-md-12 col-lg-4">
                    <x-pump-card :pump="$pump" />
                </div>
            @endforeach
        </div>
    </div>
@endsection

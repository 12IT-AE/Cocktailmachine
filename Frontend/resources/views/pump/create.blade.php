@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Create Pump</h2>
        <form action="{{ route('pump.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-3">
                <label for="container_id">Container</label>
                <select name="container_id" id="container_id" class="form-control">
                    @foreach($containers as $container)
                        <option value="{{ $container->id }}">Container: {{ $container->id }} - {{ $container->liquid->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Create Pump</h2>
        <form action="{{ route('pump.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="container_id">Container</label>
                    <select name="container_id" id="container_id" class="form-control">
                        @foreach($containers as $container)
                            <option value="{{ $container->id }}">Container: {{ $container->id }} - {{ $container->liquid->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="pin">Pin</label>
                    <select name="pin" id="pin" class="form-control">
                        @foreach($pins as $pin)
                            <option value="{{ $pin->value }}">{{ $pin->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="flowrate">Flowrate (Ml/S)</label>
                    <input type="number" id="flowrate" name="flowrate" value="0" min="1" required>
                </div>
                <div class="col-12">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
            </div>
            
        </form>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Pump</h1>
        <form action="{{ route('pump.update', $pump->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="container_id">Container</label>
                <select name="container_id" id="container_id" class="form-control" required>
                    @foreach($containers as $container)
                        <option value="{{ $container->id }}" {{ $pump->container_id == $container->id ? 'selected' : '' }}>
                            {{ $container->liquid->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="pin">Pin</label>
                <select name="pin" id="pin" class="form-control" required>
                    @foreach($pins as $pin)
                        <option value="{{ $pin->value }}" {{ $pump->pin == $pin->value ? 'selected' : '' }}>
                            {{ $pin->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Pump</button>
        </form>

        <form action="{{ route('pump.destroy', $pump->id) }}" method="POST" class="mt-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Pump</button>
        </form>
    </div>
@endsection
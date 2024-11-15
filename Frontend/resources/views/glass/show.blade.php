@extends('layouts.app')

@section('title', 'Show Glass')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1>{{ $glass->name }}</h1>
            <form action="{{ route('glass.destroy', $glass->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this glass?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset($glass->image) }}" class="img-fluid img-thumbnail" alt="{{ $glass->name }}" style="max-width: 100%; max-height: 300px; object-fit: cover;">
                </div>
                <div class="col-md-8">
                    <p cla  ss="card-text"><strong>Volume:</strong> {{ $glass->volume }} ml</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
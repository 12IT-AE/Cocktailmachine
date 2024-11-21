@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container mt-5">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

</div>
@endsection
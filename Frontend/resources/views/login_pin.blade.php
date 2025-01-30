@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container mt-5">
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password_pin" name="password" class="form-control" required>
    </div>
    <button type="button" class="btn btn-primary" id='login_pin'>Login</button>
</div>
@endsection
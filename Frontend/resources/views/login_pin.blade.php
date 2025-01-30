@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 320px;">
        <h2 class="text-center mb-3">Enter PIN to Login</h2>
        
        <form action="{{ route('login_pin') }}" method="POST">
            @csrf
            <input type="password" id="pin" name="password_pin" class="form-control text-center fs-4 mb-3" readonly>
            
            <!-- 3-Column Numeric Keypad -->
            <div class="container">
                <div class="row g-2">
                    @foreach([1, 2, 3, 4, 5, 6, 7, 8, 9] as $number)
                        <div class="col-4">
                            <button type="button" class="num-btn btn btn-light w-100 py-3 fs-4">{{ $number }}</button>
                        </div>
                    @endforeach
                    <div class="col-4">
                        <button type="button" class="clear-btn btn btn-danger w-100 py-3 fs-4">C</button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="num-btn btn btn-light w-100 py-3 fs-4">0</button>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary w-100 py-3 fs-4">OK</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        const $pinInput = $('#pin');
        const $numButtons = $('.num-btn');
        const $clearButton = $('.clear-btn');

        // Add number to PIN input
        $numButtons.on('click', function() {
            if ($pinInput.val().length < 6) { // Limit to 6 digits
                $pinInput.val($pinInput.val() + $(this).text());
            }
        });

        // Clear the PIN input
        $clearButton.on('click', function() {
            $pinInput.val('');
        });
    });
</script>
@endsection

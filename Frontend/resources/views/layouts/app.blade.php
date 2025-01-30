<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', "DrinkPad '24")</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jaini+Purva&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Teko:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link href={{ asset('css/layout.css') }} rel="stylesheet">
    <link href={{ asset('css/cards.css') }} rel="stylesheet">
    @stack('styles')
    <style>
        .admin-button {
            position: fixed;
            bottom: 10px;
            right: 100px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">

        <!-- Admin -->
        @if(session('admin'))

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Drinkpad '24</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Navigation umschalten">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('recipe.index') }}>Rezepte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('liquid.index') }}>Flüssigkeiten</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('container.index') }}>Behälter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('pump.index') }}>Pumpen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('glass.index') }}>Gläser</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('garnish.index') }}>Garnierungen</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container mt-3">
            <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Zurück</a>
        </div>
        <div class="vertical-button left">
            <button onclick="previousRoute()"><</button>
        </div>
        
        <div class="vertical-button right">
            <button onclick="nextRoute()">></button>
        </div> 

        @endif

        <!-- Admin Button -->
        @if (session('admin'))
            <form method="POST" action="{{ route('logout') }}" class="admin-button">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        @else
            <a href="{{ route('login_pin') }}" class="btn btn-primary admin-button">Admin</a>
        @endif

        <!-- Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                <ul>
                    <li>{{ session('error') }}</li>
                </ul>
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ session('success') }}</li>
                </ul>
            </div>
        @endif

        <!-- Content -->
        @yield('content')
        
    </div>
    
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var routeOrder = [
        "{{ route('recipe.index') }}",
        "{{ route('liquid.index') }}",
        "{{ route('container.index') }}",
        "{{ route('pump.index') }}",
        "{{ route('ingredient.index') }}",
        "{{ route('glass.index') }}",
        "{{ route('garnish.index') }}"
    ]
    function previousRoute() {
        var currentRoute = window.location.href;
        var currentIndex = routeOrder.indexOf(currentRoute);
        if (currentIndex > 0) {
            window.location.href = routeOrder[currentIndex - 1];
        }
        else{
            window.location.href = routeOrder[routeOrder.length - 1];
        }
    }

    function nextRoute() {
        var currentRoute = window.location.href;
        var currentIndex = routeOrder.indexOf(currentRoute);
        if (currentIndex < routeOrder.length - 1) {
            window.location.href = routeOrder[currentIndex + 1];
        }
        else{
            window.location.href = routeOrder[0];
        }
    }
</script>
@stack('scripts')

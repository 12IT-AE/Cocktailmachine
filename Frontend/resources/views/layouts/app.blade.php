<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', "DrinkPad '24")</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href={{ asset('css/layout.css') }} rel="stylesheet">
    @stack('styles')
</head>

<body>
    <div class="container mt-5">
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
                        <a class="nav-link" href={{ route('ingredient.index') }}>Zutaten</a>
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

        <div class="container mt-3">
            <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Zurück</a>
        </div>
        @yield('content')
    </div>

    <div class="vertical-button left">
        <button onclick="previousRoute()"><</button>
    </div>
    
    <div class="vertical-button right">
        <button onclick="nextRoute()">></button>
    </div>
    
</body>

</html>
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
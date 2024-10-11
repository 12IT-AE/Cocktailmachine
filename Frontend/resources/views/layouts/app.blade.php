<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', "DrinkPad '24")</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href= {{ asset('css/layout.css') }} rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="container mt-5">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">DrinkPad '24</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Navigation umschalten">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href={{ route("recipe.index") }}>Rezept</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ route("liquid.index") }}>Flüssigkeit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ route("container.index") }}>Behälter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ route("pump.index") }}>Pumpe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Zutat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Glas</a>
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

        <div class="container mt-3">
            <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Zurück</a>
        </div>
        @yield('content')
    </div>
</body>
</html>

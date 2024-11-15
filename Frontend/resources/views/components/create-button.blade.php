@props(['model'])

@php
    // Determine the base route name from the current route
    $routeName = request()->route()->getName();
    $baseRoute = explode('.', $routeName)[0]; // Assumes routes are named like 'model.index', 'model.create', etc.
    $createRoute = $baseRoute . '.create';
@endphp

    
    <a href="{{ route($createRoute) }}" class="btn btn-primary mb-3">
        Neue/r {{ ucfirst($model) }} erstellen
    </a>


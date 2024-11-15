<?php

namespace App\Providers;
use App\View\Components\{GlassMedia, LiquidCard, ContainerCard, PumpCard};
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void

    {
        Blade::component('glass-media', GlassMedia::class);
        Blade::component('liquid-card', LiquidCard::class);
        Blade::component('container-card', ContainerCard::class);
        Blade::component('pump-card', PumpCard::class);

    }
}

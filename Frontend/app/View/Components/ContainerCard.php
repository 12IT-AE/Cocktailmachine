<?php

namespace App\View\Components;

use App\Models\Container;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ContainerCard extends Component
{
    public $container;

    /**
     * Create a new component instance.
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.container-card');
    }
}
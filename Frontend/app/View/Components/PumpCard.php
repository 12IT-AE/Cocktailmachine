<?php

namespace App\View\Components;

use App\Models\Pump;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PumpCard extends Component
{
    public $pump;

    /**
     * Create a new component instance.
     */
    public function __construct(Pump $pump)
    {
        $this->pump = $pump;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pump-card');
    }
}
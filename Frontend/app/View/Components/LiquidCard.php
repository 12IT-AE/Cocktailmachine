<?php

namespace App\View\Components;

use App\Models\Liquid;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LiquidCard extends Component
{
    public $liquid;

    /**
     * Create a new component instance.
     */
    public function __construct(Liquid $liquid)
    {
        $this->liquid = $liquid;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.liquid-card');
    }
}

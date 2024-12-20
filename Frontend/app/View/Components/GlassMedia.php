<?php

namespace App\View\Components;

use App\Models\Glass;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GlassMedia extends Component
{
    public $glass;

    /**
     * Create a new component instance.
     */
    public function __construct(Glass $glass)
    {
        $this->glass = $glass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.glass-media');
    }
}

<?php

namespace App\View\Components;

use App\Models\Liquid;
use App\Models\Ingredient;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LiquidInput extends Component
{
    public $liquids;
    public $ingredient;

    /**
     * Create a new component instance.
     */
    public function __construct($liquids, Ingredient $ingredient = null)
    {
        $this->liquids = $liquids;
        $this->ingredient = $ingredient;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.liquid-input');
    }
}

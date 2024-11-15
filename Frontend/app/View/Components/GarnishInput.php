<?php

namespace App\View\Components;

use App\Models\Garnish;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GarnishInput extends Component
{
    public $garnishes;

    /**
     * Create a new component instance.
     */
    public function __construct($garnishes)
    {
        $this->garnishes = $garnishes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.garnish-input');
    }
}
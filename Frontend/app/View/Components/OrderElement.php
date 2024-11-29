<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OrderElement extends Component
{
    public $recipe;

    public function __construct($recipe)
    {
        $this->recipe = $recipe;
    }

    public function render()
    {
        return view('components.order-element');
    }
}

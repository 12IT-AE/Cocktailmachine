<?php

namespace App\View\Components;

use App\Models\DefaultRecipe;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RecipeCard extends Component
{
    public $recipe;

    /**
     * Create a new component instance.
     */
    public function __construct(DefaultRecipe $recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.recipe-card');
    }
}

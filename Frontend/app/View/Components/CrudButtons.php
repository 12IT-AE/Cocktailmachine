<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;

class CrudButtons extends Component
{
    public $id;
    public $baseRoute;

    public function __construct($id)
    {
        $this->id = $id;
        $this->baseRoute = $this->getBaseRoute();
    }

    private function getBaseRoute()
    {
        // Assuming routes are named like 'resource.show', 'resource.edit', etc.
        $currentRouteName = Route::currentRouteName();
        return explode('.', $currentRouteName)[0];
    }

    public function render()
    {
        return view('components.crud-buttons');
    }
}

<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $title;
    public $subtitle;
    public $id;

    public function __construct($title = null, $subtitle = null, $id = null)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->id = $id;
    }

    public function render()
    {
        return view('components.card');
    }
}

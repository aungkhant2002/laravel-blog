<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Li extends Component
{
    public $routeName, $title;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($routeName, $title)
    {
        $this->routeName = $routeName;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.li');
    }
}

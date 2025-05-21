<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Dropdown extends Component
{
    /**
     * The dropdown alignment.
     *
     * @var string
     */
    public $align;

    /**
     * Create a new component instance.
     *
     * @param  string  $align
     * @return void
     */
    public function __construct($align = 'right')
    {
        $this->align = $align;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.dropdown');
    }
} 
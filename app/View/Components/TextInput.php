<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TextInput extends Component
{
    /**
     * Whether the input is disabled.
     *
     * @var bool
     */
    public $disabled;

    /**
     * Create a new component instance.
     *
     * @param  bool  $disabled
     * @return void
     */
    public function __construct($disabled = false)
    {
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.text-input');
    }
} 
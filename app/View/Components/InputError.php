<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputError extends Component
{
    /**
     * The error messages.
     *
     * @var array
     */
    public $messages;

    /**
     * Create a new component instance.
     *
     * @param  array|string  $messages
     * @return void
     */
    public function __construct($messages)
    {
        $this->messages = (array) $messages;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.input-error');
    }
} 
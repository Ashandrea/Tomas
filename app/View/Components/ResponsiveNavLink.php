<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ResponsiveNavLink extends Component
{
    /**
     * Whether the link is active.
     *
     * @var bool
     */
    public $active;

    /**
     * Create a new component instance.
     *
     * @param  bool  $active
     * @return void
     */
    public function __construct($active = false)
    {
        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.responsive-nav-link');
    }
} 
<?php

namespace App\View\Components;

use Illuminate\View\Component;

/**
 * Blade component for rendering a breadcrumb.
 */
class Breadcrumb extends Component
{
    public function __construct(
        public array $nodes,
    ) {}

    public function render()
    {
        return view('components.breadcrumb');
    }
}

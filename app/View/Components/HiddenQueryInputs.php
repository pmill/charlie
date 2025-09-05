<?php

namespace App\View\Components;

use Illuminate\View\Component;

/**
 * Blade component for rendering hidden form inputs based on the current query string. This is useful for GET forms where
 * we want to preserve the current query string.
 */
class HiddenQueryInputs extends Component
{
    public array $query;

    public array $exclude = [];

    public function __construct($query = null, array $exclude = [])
    {
        $this->query = $query ?? request()->query();
        $this->exclude = $exclude;
    }

    public function render()
    {
        return view('components.hidden-query-inputs');
    }
}

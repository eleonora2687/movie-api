<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SortingAndSearchBar extends Component
{
    public $sortOptions;
    public $placeholder;

    public function __construct($sortOptions, $placeholder = 'Search...')
    {
        $this->sortOptions = $sortOptions;
        $this->placeholder = $placeholder;
    }

    public function render()
    {
        return view('components.sorting-and-search-bar');
    }
}

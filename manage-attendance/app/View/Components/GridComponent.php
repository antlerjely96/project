<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GridComponent extends Component
{
    private $columns;
    private $items;

    /**
     * Create a new component instance.
     */
    public function __construct($items, $columns)
    {
        $this->items = $items;
        $this->columns = $columns;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.grid-component', [
            'items' => $this->items,
            'columns' => $this->columns
        ]);
    }
}

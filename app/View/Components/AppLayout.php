<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     * If current route is under /admin, render the dedicated admin layout (with sidebar).
     */
    public function render(): View
    {
        if (request()->is('admin*')) {
            return view('layouts.admin');
        }

        return view('layouts.app');
    }
}

<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class TailadminAppLayout extends Component
{
    public function __construct(public string $page = 'dashboard') {}

    public function render(): View
    {
        return view('layouts.tailadmin-app');
    }
}

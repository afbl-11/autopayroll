<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AttendanceOverview extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $employeeId = null,
        public $name = null,
        public $status = null,
        public $profile = null,
        public $source = null,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.attendance-overview');
    }
}

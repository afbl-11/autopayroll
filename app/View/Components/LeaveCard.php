<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LeaveCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $leaveId = null,
        public $employeeId = null,
        public $leaveType = null,
        public $message = null,
        public $date = null,
        public $status = null,
    )
    {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.leave-card');
    }
}

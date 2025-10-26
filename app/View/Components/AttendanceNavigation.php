<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AttendanceNavigation extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $daysActive,
        public $totalLate,
        public $totalOvertime,
        public $noClockOut,
        public $totalAbsences,
        public ?string $leaveBalance = '15',

    )
    {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.attendance-navigation');
    }
}

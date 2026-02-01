<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AttendanceLogs extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $clockIn = null,
        public $clockOut = null,
        public $dayDate = null, //15, 20, numerical
        public $dateWeek = null, //Sun, mon, tues etc..
        public $duration = null,
        public $late = null,
        public $overtime = null,
        public $regularHours = null,
        public $startPercent = null,
        public $workedPercent = null,
        public $labels = null,
        public $timeline = null,
        public $status = null,
        public $statusLabel = null,

    )
    {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.attendance-logs');
    }
}

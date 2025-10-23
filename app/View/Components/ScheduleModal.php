<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ScheduleModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $employee_id,
        public ?string $shift_id = null,
        public ?string $start_time = null,
        public ?string $end_time = null,
        public ?string $break_start  = null,
        public ?string $break_end = null,
        public ?bool $lunch_time = null,
    )
    {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.schedule-modal');
    }
}

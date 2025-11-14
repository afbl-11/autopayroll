<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdjustmentModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $title = null,
        public $message = null,
        public $type = null,
        public $employeeId = null,
        public $requestId = null,
        public $logDate = null,
        public $affected_date = null,
        public $startDate = null,
        public $endDate = null,
        public $name = null


    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.adjustment-modal');
    }
}

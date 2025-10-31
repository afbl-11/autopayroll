<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ScheduleCards extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $image = null,
        public string $name,
        public string $id,
        public ?array $options = null,
        public ?string $start = null,
        public ?string $end = null,
        public  $scheduleDays,
        public ?string $description = null,
        public ?string $labels = null,
    )
    {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.schedule-cards');
    }
}

<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CompanyHeader extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $id,
        public ?string $logo,
        public string $tin,
        public string $address,
        public string $industry,
        public ?string $latitude,
        public ?string $longitude,
        public ?string $employee_count,
    )
    {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.company-header');
    }
}

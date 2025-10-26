<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardNavigation extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
//        genera
        public string $name,
        public string $id,
        public ?string $companyLogo = null,
        public ?string $employeeProfile = null,
//for employees
        public ?string $position,
//        for companies
        public ?string $tin,
        public ?string $address,
        public ?string $industry,
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

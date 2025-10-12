<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormRadio extends Component
{
    /**
     * Create a new component instance.
     */
    public string $name;
    public string $label;
    public ?string $selected;
    public bool $required;

    public function __construct(
        string $name,
        string $label,
        string $selected = null,
        bool $required = false
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->selected = $selected ?? old($name);
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-radio');
    }
}

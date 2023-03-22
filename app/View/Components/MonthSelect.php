<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MonthSelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $months;
    public $col;

    public function __construct(string $col = '6')
    {
        $this->months = array(
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        );

        $this->col = $col;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.month-select');
    }
}

<?php

namespace App\View\Components;

use App\Models\SubDistrict;
use Illuminate\View\Component;

class SubDistrictDropdown extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $sub_districts;
    public $col;

    public function __construct(string $col = '6')
    {
        $this->sub_districts = SubDistrict::getSubDistrictByDistrictUser();
        $this->col = $col;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sub-district-dropdown');
    }
}

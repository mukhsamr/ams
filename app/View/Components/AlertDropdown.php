<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AlertDropdown extends Component
{
    public $total;
    public $success;
    public $failures;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($total, $success, $failures)
    {
        $this->total = $total;
        $this->success = $success;
        $this->failures = $failures;
    }

    public function message()
    {
        $total = '<strong>' . $this->total . '</strong>&nbsp;diimport';
        $success = '<strong class="text-success">' . $this->success . '</strong>&nbsp;berhasil';
        $fail = '<strong class="text-danger">' . (intval($this->total) - intval($this->success)) . '</strong>&nbsp;gagal';

        return implode(',&nbsp;', [$total, $success, $fail]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert-dropdown');
    }
}

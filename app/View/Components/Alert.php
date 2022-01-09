<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type;
    public $message;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $message = null, $warning = null)
    {
        $this->type = $type;
        $this->message = $message;
        $this->warning = $warning;
    }

    public function message()
    {
        if ($this->type == 'success') {
            return 'Berhasil ' . $this->message;
        } elseif ($this->type == 'warning') {
            return $this->message = $this->warning;
        } else {
            return 'Gagal ' . $this->message;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert');
    }
}

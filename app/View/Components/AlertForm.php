<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AlertForm extends Component
{
    public $action;
    public $message;
    public $input;
    public $name;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($action, $message, $input, $name)
    {
        $this->action = $action;
        $this->message = $message;
        $this->input = $input;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert-form');
    }
}

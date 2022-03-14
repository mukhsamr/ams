<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Option extends Component
{
    public $object;
    public $value;
    public $text;

    public function __construct($object, $value, $text)
    {
        $this->object = $object;
        $this->value = $value;
        $this->text = $text;
    }

    public function render()
    {
        return view('components.option');
    }
}

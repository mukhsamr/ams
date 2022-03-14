<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class JournalExport implements FromView
{
    private $journals;
    private $page;

    public function __construct($journals, $page)
    {
        $this->journals = $journals;
        $this->page = $page;
    }

    public function view(): View
    {
        return view('exports.' . $this->page, [
            'journals' => $this->journals->get()
        ]);
    }
}

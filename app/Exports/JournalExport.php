<?php

namespace App\Exports;

use App\Models\Journal;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class JournalExport implements FromView
{
    private $role;
    private $optional;

    public function __construct($role, ...$optional)
    {
        $this->role = $role;
        $this->optional = $optional;
    }

    public function view(): View
    {
        $journals = Journal::with('subject', 'competence', 'subGrade');

        foreach ($this->optional as $where) {
            foreach ($where as $column => $value) {
                if (!$value) continue;
                $journals->where($column, $value);
            }
        }

        return view('exports.journal', [
            'journals' => $journals->get()
        ]);
    }
}

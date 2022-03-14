<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Score;

class LedgerController extends Controller
{
    public function index()
    {
        $scores = Score::joinAll()->get();
        $data = [
            'subjects' => $scores->unique('subject_id'),
            'subGrades' => $scores->unique(fn ($v) => $v->subject_id . $v->sub_grade_id),
        ];

        return view('operator.ledgers.ledger', $data);
    }
}

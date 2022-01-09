<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Score;

class LedgerController extends Controller
{
    public function index()
    {
        $score = Score::all();
        $data = [
            'subjects' => $score->unique('subject_id'),
            'subGrades' => $score->unique(fn ($v) => $v['subject_id'] . $v['sub_grade_id']),
        ];

        return view('operator.ledgers.ledger', $data);
    }
}

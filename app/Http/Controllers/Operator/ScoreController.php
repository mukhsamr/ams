<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Score;

class ScoreController extends Controller
{
    public function index()
    {
        $scores = Score::all();
        $data = [
            'subjects' => $scores->unique('subject_id')->load('subject'),
            'subGrades' => $scores->unique(fn ($v) => $v['subject_id'] . $v['sub_grade_id'])->load('subGrade'),
            'competences' => $scores->unique(fn ($v) => $v['subject_id'] . $v['sub_grade_id'] . $v['competence_id'])
                ->load('competence')
                ->sortBy(fn ($q) => $q->competence->competence . $q->competence->type)
        ];
        return view('operator.scores.score', $data);
    }
}

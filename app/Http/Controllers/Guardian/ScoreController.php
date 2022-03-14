<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\Subject;

class ScoreController extends Controller
{
    public function index()
    {
        $subGrade = auth()->user()->guardian->subGrade;

        $data = [
            'subGrade' => $subGrade,
            'subjects' => Subject::whereRelation('scores', 'sub_grade_id', $subGrade->id)->get(['id', 'subject']),
            'competences' => Competence::whereRelation('scores', 'sub_grade_id', $subGrade->id)->get(),
        ];
        return view('guardian.scores.score', $data);
    }
}

<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\Guardian;
use App\Models\Subject;

class ScoreController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $guardian = Guardian::with('subGrade')->firstWhere('user_id', $user->id);
        $data = [
            'subGrade' => $guardian->subGrade,
            'subjects' => Subject::whereRelation('score', 'sub_grade_id', $guardian->subGrade->id)->get(),
            'competences' => Competence::whereRelation('score', 'sub_grade_id', $guardian->subGrade->id)->get(),
        ];
        return view('guardian.scores.score', $data);
    }
}

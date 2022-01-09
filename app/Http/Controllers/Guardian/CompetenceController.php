<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\Guardian;
use App\Models\Subject;

class CompetenceController extends Controller
{
    public function index($subject = null)
    {
        $user = auth()->user();
        $guardian = Guardian::with('subGrade')->firstWhere('user_id', $user->id);

        $subGrade = $guardian->subGrade;
        $subjects = Subject::all();
        $subject ??= $subjects->first()->id ?? null;

        $data = [
            'grade' => $subGrade->grade,
            'subjects' => $subjects,
            'competences' => Competence::with('grade')->where([
                'subject_id' => $subject,
                'grade_id' => $subGrade->grade_id
            ])->get(),

            'selected'  => [
                'subject' => $subject
            ]
        ];
        return view('guardian.competences.competence', $data);
    }
}

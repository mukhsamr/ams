<?php

namespace App\Http\Controllers\Operator;

use App\Exports\JournalExport;
use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\Journal;
use App\Models\SubGrade;
use App\Models\Subject;
use Maatwebsite\Excel\Facades\Excel;

class JournalController extends Controller
{
    public function index($subject = null, $subGrade = null)
    {
        $subjects = Subject::all();
        $journals = Journal::with('subject', 'competence', 'subGrade');
        $competences = Competence::with('grade');
        $subGrades = SubGrade::with('grade')->get();

        if ($subject) {
            $journals->where('subject_id', $subject);
            $competences->where('subject_id', $subject);
        };
        if ($subGrade) {
            $journals->where('sub_grade_id', $subGrade);
            $competences->where('grade_id', $subGrades->find($subGrade)->grade_id);
        };

        $data = [
            'subGrades' => $subGrades,
            'journals'  => $journals->paginate(10),
            'subjects'  => $subjects,
            'competences' => $competences->get(),
            'selected'  => [
                'subject'   => $subject,
                'subGrade'  => $subGrade
            ]
        ];
        return view('operator.journals.journal', $data);
    }

    public function export($subject, $subGrade)
    {
        $name = ($subject ? ' ' . Subject::find($subject)->subject : null) . ($subGrade ? ' ' . SubGrade::find($subGrade)->sub_grade : null);

        return Excel::download(new JournalExport('operator', ['subject_id' => $subject], ['sub_grade_id' => $subGrade]), "Jurnal$name.xlsx");
    }
}

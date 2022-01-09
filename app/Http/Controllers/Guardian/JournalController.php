<?php

namespace App\Http\Controllers\Guardian;

use App\Exports\JournalExport;
use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\Guardian;
use App\Models\Journal;
use App\Models\SubGrade;
use App\Models\Subject;
use Maatwebsite\Excel\Facades\Excel;

class JournalController extends Controller
{
    public function index($subject = null)
    {
        $user = auth()->user();
        $guardian = Guardian::firstWhere('user_id', $user->id);

        $subGrade = $guardian->subGrade;
        $journals = Journal::with('subject', 'competence.grade', 'subGrade')->where('sub_grade_id', $subGrade->id);
        if ($subject) $journals->where('subject_id', $subject);

        $data = [
            'subGrade' => $subGrade,
            'journals' => $journals->paginate(10),
            'subjects' => Subject::all(),
            'selected' => $subject,
            'competences' => Competence::with('grade')->where('grade_id', $subGrade->grade_id)->get()
        ];
        return view('guardian.journals.journal', $data);
    }

    public function export(SubGrade $subGrade, $subject)
    {
        $name = $subject ? $subGrade->sub_grade . ' ' . Subject::find($subject)->subject : $subGrade->sub_grade;
        return Excel::download(new JournalExport('guardian', ['sub_grade_id' => $subGrade->id], ['subject_id' => $subject]), "Jurnal kelas $name.xlsx");
    }
}

<?php

namespace App\Http\Controllers\Guardian;

use App\Exports\JournalExport;
use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\Journal;
use App\Models\Subject;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $subjects = Subject::get(['id', 'subject']);
        $subGrade = auth()->user()->guardian->subGrade;
        $subject = $request->subject;

        $date = date('Y-m-d');
        $start = $request->start ?? $date;
        $end = $request->end ?? $date;

        $journals = Journal::joinFilter($start, $end)
            ->where('sub_grade_id', $subGrade->id);
        if ($subject) $journals->where('subject_id', $subject);

        $data = [
            'start' => $start,
            'end' => $end,
            'subGrade' => $subGrade,
            'journals' => $journals->paginate(10)->withQueryString(),
            'subjects' => $subjects,
            'selected' => $subject,
        ];
        return view('guardian.journals.journal', $data);
    }

    public function edit($id)
    {
        $subGrade = auth()->user()->guardian->subGrade;

        $journal = Journal::addSelect([
            'summary' => Competence::select('summary')
                ->whereColumn('id', 'journals.competence_id')
                ->limit(1)
        ])->find($id);

        return view('guardian.journals.modal-edit', [
            'journal' => $journal,
            'subjects' => Subject::get(['id', 'subject']),
            'subGrade' => $subGrade,
            'competences' => Competence::where('grade_id', $subGrade->grade_id)->get(),
        ]);
    }

    // ===


    public function export(Request $request)
    {
        $subGrade = auth()->user()->guardian->subGrade;
        $journals = Journal::where('sub_grade_id', $subGrade->id)->joinFilter($request->start, $request->end);

        $subject = $request->subject ?? null;
        $name = 'Jurnal Kelas ' . $subGrade->sub_grade;
        if ($subject) {
            $journals->where('journals.subject_id', $subject);
            $name .= ' ' . Subject::find($subject)->subject;
        }

        $name .= ' -- ' . formatDate($request->start) . ' - ' . formatDate($request->end) . '.xlsx';

        return Excel::download(new JournalExport($journals, 'guardians/journal'), $name);
    }
}

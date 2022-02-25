<?php

namespace App\Http\Controllers\Operator;

use App\Exports\JournalExport;
use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\Journal;
use App\Models\SubGrade;
use App\Models\Subject;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $subjects = Subject::all(['id', 'subject']);
        $subGrades = SubGrade::all();

        $date = date('Y-m-d');

        $start = $request->start ?? $date;
        $end = $request->end ?? $date;

        $subject = $request->subject;
        $subGrade = $request->subGrade;

        $journals = Journal::joinFilter($start, $end);

        if ($subject) $journals->where('journals.subject_id', $subject);
        if ($subGrade) $journals->where('sub_grade_id', $subGrade);

        $data = [
            'subGrades' => $subGrades,
            'journals'  => $journals->paginate(10)->withQueryString(),
            'subjects'  => $subjects,
            'selected'  => [
                'start' => $start,
                'end'   => $end,
                'subject'   => $subject,
                'subGrade'  => $subGrade,
            ]
        ];
        return view('operator.journals.journal', $data);
    }

    public function edit($id)
    {
        $journal = Journal::addSelect([
            'summary' => Competence::select('summary')
                ->whereColumn('id', 'journals.competence_id')
                ->limit(1),
            'grade_id' => SubGrade::select('grade_id')
                ->whereColumn('id', 'journals.sub_grade_id')
                ->limit(1)
        ])->find($id);

        return view('teacher.journals.modal-edit', [
            'journal' => $journal,
            'subjects' => Subject::get(['id', 'subject']),
            'subGrades' => SubGrade::all(),
            'competences' => Competence::all(),
        ]);
    }

    public function export(Request $request)
    {
        $journals = (new Journal)->joinFilter($request->start, $request->end);
        $subject = $request->subject ?? null;
        $subGrade = $request->sub_grade ?? null;

        $name = 'Jurnal';
        if ($subject) {
            $journals->where('journals.subject_id', $subject);
            $name .= ' ' . Subject::find($subject)->subject;
        }
        if ($subGrade) {
            $journals->where('journals.sub_grade_id', $subGrade);
            $name .= ' ' . SubGrade::find($subGrade)->sub_grade;
        }

        $name .= ' -- ' . formatDate($request->start) . ' - ' . formatDate($request->end) . '.xlsx';

        return Excel::download(new JournalExport($journals, 'operators/journal'), $name);
    }
}

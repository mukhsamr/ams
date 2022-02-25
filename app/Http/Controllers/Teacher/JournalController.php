<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Exports\JournalExport;
use App\Imports\JournalImport;
use App\Models\Competence;
use App\Models\Journal;
use App\Models\SubGrade;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $subjects = $user->subjects;
        $subGrades = $user->subGrades;
        $subject = $subjects->find($request->subject) ?? $subjects->first();
        $subGrade = $subGrades->find($request->subGrade) ?? $subGrades->first();

        $subject_id = $subject ? $subject->id : null;
        $subGrade_id = $subGrade ? $subGrade->id : null;

        $journals = $user->journals()->joinFilter()
            ->where('journals.subject_id', $subject_id)
            ->where('journals.sub_grade_id', $subGrade_id)
            ->paginate(10)->withQueryString();

        $data = [
            'subjects'  => $subjects,
            'subGrades' => $subGrades,
            'journals'  => $journals,
            'selected'  => [
                'subject'   => $subject_id,
                'subGrade'  => $subGrade_id,
            ]
        ];

        return view('teacher.journals.journal', $data);
    }

    public function create()
    {
        $user = auth()->user();
        return view('teacher.journals.modal-create', [
            'subjects'  => $user->subjects,
            'subGrades' => $user->subGrades,
            'competences' => $user->competences,
        ]);
    }

    public function store(Request $request)
    {
        $request->merge([
            'user_id' => auth()->user()->id,
            'version_id' => session('version')->id,
        ]);
        try {
            Journal::create($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'tambah jurnal ' . $request->date;
        return back()->with('alert', $alert);
    }

    public function edit($id)
    {
        $user = auth()->user();

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
            'subjects' => $user->subjects,
            'subGrades' => $user->subGrades,
            'competences' => $user->competences,
        ]);
    }

    public function update(Request $request)
    {
        if (!$request->is_swapped) $request->merge(['is_swapped' => null]);
        try {
            Journal::find($request->id)->update($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'update jurnal ' . $request->date;
        return back()->with('alert', $alert);
    }

    public function destroy(Journal $journal)
    {
        try {
            $journal->delete();
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'hapus jurnal ' . $journal->date;
        return back()->with('alert', $alert);
    }

    public function import(Request $request)
    {
        $request->merge([
            'user_id' => auth()->user()->id,
            'version_id' => session('version')->id,
        ]);
        $import = new JournalImport($request);
        $import->import($temp = $request->import->store('temp'));

        Storage::delete($temp);
        return back()->with('import', $import);
    }

    public function export(Request $request)
    {
        $user = auth()->user();

        $journals = $user->journals()->joinFilter($request->start, $request->end);
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

        return Excel::download(new JournalExport($journals, 'teachers/journal'), $name);
    }
}

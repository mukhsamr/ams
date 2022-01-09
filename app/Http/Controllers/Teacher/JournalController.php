<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Exports\JournalExport;
use App\Imports\JournalImport;
use App\Models\Journal;
use App\Models\SubGrade;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class JournalController extends Controller
{
    public function index($subject = null, $subGrade = null)
    {
        $user = auth()->user();

        $grade = $subGrade ? SubGrade::find($subGrade)->id : null;
        $data = [
            'subGrades' => $user->subGrade->load('grade'),
            'journals'  => $user->getJournal($subject, $subGrade)->paginate(15),
            'subjects'  => $user->subject,
            'competences' => $user->getCompetence($subject, $grade)->get(),
            'selected'  => [
                'subject'   => $subject,
                'subGrade'  => $subGrade,
            ]
        ];

        return view('teacher.journals.journal', $data);
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

    public function update(Request $request)
    {
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
        $subject = $request->subject ? Subject::find($request->subject)->subject : null;
        $subGrade = $request->subGrade ? SubGrade::find($request->subGrade)->sub_grade : null;
        $name = str_replace('&nbsp;', ' ', $user->userable->nama);
        $file = 'Jurnal ' . implode('', [$name, " $subject", " $subGrade"]) . '.xlsx';

        return Excel::download(new JournalExport('teacher', ['user_id' => $user->id], ['subject_id' => $request->subject], ['sub_grade_id' => $request->subGrade]), $file);
    }
}

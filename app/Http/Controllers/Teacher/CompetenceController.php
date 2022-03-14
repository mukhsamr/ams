<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompetenceRequest;
use App\Imports\CompetenceImport;
use App\Models\Competence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompetenceController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $subjects = $user->subjects;
        $grades = $user->grades();

        $subject = $request->subject ?? $subjects->first()->id ?? null;
        $grade = $request->grade ?? $grades->first()->id ?? null;

        $competences = Competence::withGrade()->where([
            'subject_id' => $subject,
            'grade_id' => $grade,
        ])->withUsed()->paginate(10)->withQueryString();

        $data = [
            'subjects' => $subjects,
            'grades' => $grades,
            'competences' => $competences,
            'selected' => [
                'subject' => $subject,
                'grade' => $grade,
            ],
        ];
        return view('teacher.competences.competence', $data);
    }

    public function store(CompetenceRequest $request)
    {
        try {
            Competence::create($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'tambah kompetensi';
        return back()->with('alert', $alert);
    }

    public function edit($id)
    {
        $user = auth()->user();
        $subjects = $user->subjects;
        $grades = $user->grades();

        return view('teacher.competences.modal-edit', [
            'subjects' => $subjects,
            'grades' => $grades,
            'competence' => Competence::withUsed()->find($id),
        ]);
    }

    public function update(CompetenceRequest $request)
    {
        try {
            Competence::find($request->id)->update($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'update kompetensi';
        return back()->with('alert', $alert);
    }

    public function destroy(Competence $competence)
    {
        try {
            $competence->delete();
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'hapus kompetensi ' . $competence->format_competence;
        return back()->with('alert', $alert);
    }

    public function import(Request $request)
    {
        $import = new CompetenceImport($request);
        $import->import($temp = $request->import->store('temp'));

        Storage::delete($temp);
        return back()->with('import', $import);
    }
}

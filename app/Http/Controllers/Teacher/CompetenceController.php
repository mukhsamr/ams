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
    public function index($subject = null, $grade = null)
    {
        $user = auth()->user();

        $subjects = $user->subject;
        $grades = $user->subGrade->unique('grade_id')->pluck('grade');

        $subject ??= $subjects->first()->id ?? null;
        $grade ??= $grades->first()->id ?? null;

        $data = [
            'subjects' => $subjects,
            'grades' => $grades,
            'competences' => $user->getCompetence($subject, $grade)->get(),
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

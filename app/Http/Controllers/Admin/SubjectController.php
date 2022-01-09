<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use App\Imports\SubjectImport;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubjectController extends Controller
{
    public function index()
    {
        return view('admin.subjects.subject', [
            'subjects' => Subject::all(),
        ]);
    }

    public function store(SubjectRequest $request)
    {
        try {
            Subject::create($request->except('_token'));
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'tambah mata pelajaran ' . $request->subject;
        return back()->with('alert', $alert);
    }

    public function update(SubjectRequest $request)
    {
        try {
            Subject::find($request->id)->update($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'update mata pelajaran ' . $request->subject;
        return back()->with('alert', $alert);
    }

    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'hapus mata pelajaran ' . $subject->subject;
        return back()->with('alert', $alert);
    }

    public function import(Request $request)
    {
        $import = new SubjectImport();
        $import->import($temp = $request->import->store('temp'));

        Storage::delete($temp);
        return back()->with('import', $import);
    }
}

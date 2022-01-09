<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GradeRequest;
use App\Models\Grade;

class GradeController extends Controller
{
    public function index()
    {
        return view('admin.grades.grade', [
            'grades' => Grade::all(),
        ]);
    }

    public function store(GradeRequest $request)
    {
        try {
            Grade::create($request->except('_token'));
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'tambah kelas';
        return back()->with('alert', $alert);
    }

    public function destroy(Grade $grade)
    {
        try {
            $grade->delete();
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'hapus kelas ' . $grade->grade;
        return back()->with('alert', $alert);
    }
}

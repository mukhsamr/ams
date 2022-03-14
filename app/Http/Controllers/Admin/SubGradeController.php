<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubGradeRequest;
use App\Models\Grade;
use App\Models\SubGrade;

class SubGradeController extends Controller
{
    public function index()
    {
        return view('admin.subGrades.subGrade', [
            'grades' => Grade::all(),
            'subGrades' => SubGrade::with('grade')->get(),
        ]);
    }

    public function store(SubGradeRequest $request)
    {
        try {
            SubGrade::create($request->except('_token'));
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'tambah Sub Kelas ' . $request->sub_grade;
        return back()->with('alert', $alert);
    }

    public function update(SubGradeRequest $request)
    {
        try {
            SubGrade::find($request->id)->update($request->except(['_token', '_method']));
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'update Sub Kelas ' . $request->sub_grade;
        return back()->with('alert', $alert);
    }

    public function destroy(SubGrade $subGrade)
    {
        try {
            $subGrade->delete();
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'hapus Sub Kelas ' . $subGrade->sub_grade;
        return back()->with('alert', $alert);
    }
}

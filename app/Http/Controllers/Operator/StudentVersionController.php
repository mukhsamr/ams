<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentVersionRequest;
use App\Models\Student;
use App\Models\StudentVersion;
use App\Models\SubGrade;
use Illuminate\Http\Request;

class StudentVersionController extends Controller
{
    public function index(Request $request)
    {
        $subGrades = SubGrade::all();
        $subGrade = $request->subGrade ?? ($subGrades->first() ? $subGrades->first()->id : null);

        $data = [
            'students' => StudentVersion::withStudent()->where('sub_grade_id', $subGrade)->get(),
            'subGrades' => $subGrades,
            'selected' => $subGrade,
        ];
        return view('operator.students.student', $data);
    }

    public function create($id)
    {
        $data = [
            'subGrade' => SubGrade::find($id) ?: SubGrade::first(),
            'students' => Student::whereDoesntHave('studentVersion', fn ($query) => $query->where('version_id', session('version')->id))->get(),
        ];
        return view('operator.students.create', $data);
    }

    function store(StudentVersionRequest $request)
    {
        try {
            StudentVersion::insert($request->input('student'));
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'tambah siswa';
        return back()->with('alert', $alert);
    }

    public function destroy(StudentVersion $student)
    {
        try {
            $student->delete();
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'hapus siswa';
        return back()->with('alert', $alert);
    }
}

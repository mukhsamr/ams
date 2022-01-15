<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        $student = new Student;
        $subGrade = auth()->user()->guardian->sub_grade_id;
        return view('guardian.students.student', [
            'students' => $student::whereRelation('studentVersion', 'sub_grade_id', $subGrade)
                ->get(),
            'columns' => $student::getColumns()
        ]);
    }
}

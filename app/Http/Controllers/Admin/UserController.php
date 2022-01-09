<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

class UserController extends Controller
{
    // Student
    public function student()
    {
        $users = User::where('userable_type', Student::class)->orderBy(
            Student::select('nama')
                ->whereColumn('userable_id', 'students.id')
                ->orderBy('nama')
                ->limit(1)
        )->paginate(15);
        $data = [
            'users' => $users,
            'students' => Student::doesntHave('user')->get(),
            'class' => Student::class,
        ];

        return view('admin.user.students', $data);
    }

    // Teacher
    public function teacher()
    {
        $users = User::with('userable')->where('userable_type', Teacher::class)->orderBy(
            Teacher::select('nama')
                ->whereColumn('userable_id', 'teachers.id')
                ->orderBy('nama')
                ->limit(1)
        )->paginate(15);
        $data = [
            'users' => $users,
            'teachers' => Teacher::doesntHave('user')->get(),
            'class' => Teacher::class,
        ];

        return view('admin.user.teachers', $data);
    }
}

<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Student;
use App\Models\SubGrade;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // === Student
    public function student(Request $request)
    {
        $keyword = $request->keyword;
        $data = [
            'users' => User::select('users.id', 'nama', 'username')
                ->withStudent()
                ->where('nama', 'like', "%$keyword%")
                ->orderBy('nama')
                ->paginate(10)
                ->withQueryString(),
            'keyword' => $keyword,
        ];

        return view('operator.users.students.student', $data);
    }

    public function studentCreate()
    {
        return view('operator.users.students.modal-create', [
            'students' => Student::doesntHave('user')->get(['id', 'nama']),
            'class' => Student::class,
        ]);
    }

    public function studentEdit($id)
    {
        return view('operator.users.students.modal-edit', [
            'user' => User::select('users.id', 'username')->withStudent()->find($id),
            'class' => Teacher::class,
        ]);
    }

    // === Teacher
    public function teacher(Request $request)
    {
        $keyword = $request->keyword;
        $data = [
            'users' => User::select('users.id', 'status', 'nama', 'username', 'level')
                ->withTeacher()
                ->where('nama', 'like', "%$keyword%")
                ->orderBy('nama')
                ->paginate(10)
                ->withQueryString(),
            'keyword' => $keyword,
        ];

        return view('operator.users.teachers.teacher', $data);
    }

    public function teacherCreate()
    {
        return view('operator.users.teachers.modal-create', [
            'teachers' => Teacher::doesntHave('user')->get(['id', 'nama']),
            'subjects' => Subject::get(['id', 'subject']),
            'subGrades' => SubGrade::get(),
            'class' => Teacher::class,
        ]);
    }

    public function teacherEdit($id)
    {
        return view('operator.users.teachers.modal-edit', [
            'user' => User::select('users.id', 'status', 'nama', 'username', 'level')->withTeacher()->find($id),
            'subjects' => Subject::select('id', 'subject')->withUser($id)->get(),
            'subGrades' => SubGrade::withUser($id)->get(),
            'class' => Teacher::class,
        ]);
    }

    // ===

    public function store(UserRequest $request)
    {
        try {
            $user = User::create($request->except(['_token', 'subGrade', 'subject']));

            // If is teacher
            if ($request->userable_type == Teacher::class) {
                $user->subGrades()->attach($request->subGrade);
                $user->subjects()->attach($request->subject);
            }
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'tambah user';
        return back()->with('alert', $alert);
    }

    public function update(UserRequest $request)
    {
        $user = User::find($request->id);
        try {
            $user->update($request->input());

            // If is teacher
            if ($request->userable_type == Teacher::class) {
                $user->subGrades()->sync($request->subGrade);
                $user->subjects()->sync($request->subject);
            }
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'update user ' . $user->userable->nama;
        return back()->with('alert', $alert);
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'hapus user ' . $user->userable->nama;
        return back()->with('alert', $alert);
    }
}

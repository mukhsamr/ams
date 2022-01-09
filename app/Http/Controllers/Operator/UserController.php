<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Student;
use App\Models\SubGrade;
use App\Models\Subject;
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

        return view('operator.user.students', $data);
    }

    // Teacher
    public function teacher()
    {
        $users = User::with(['userable', 'subGrade:id', 'subject:id'])->where('userable_type', Teacher::class)->orderBy(
            Teacher::select('nama')
                ->whereColumn('userable_id', 'teachers.id')
                ->orderBy('nama')
                ->limit(1)
        )->paginate(15);

        $data = [
            'users' => $users,
            'teachers' => Teacher::doesntHave('user')->get(),
            'class' => Teacher::class,
            'subjects' => Subject::all(),
            'subGrades' => SubGrade::all(),
        ];

        return view('operator.user.teachers', $data);
    }

    // ===

    public function store(UserRequest $request)
    {
        try {
            $user = User::firstOrCreate($request->except(['_token', 'subGrade', 'subject']));
            $user->subGrade()->attach($request->subGrade);
            $user->subject()->attach($request->subject);
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
            $user->update($request->validated());
            $user->subGrade()->sync($request->subGrade);
            $user->subject()->sync($request->subject);
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

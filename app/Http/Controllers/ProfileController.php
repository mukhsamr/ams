<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $type = auth()->user()->userable_type;
        $type == Teacher::class ? $this->teacher() : $this->student();
    }

    public function student()
    {
        return view('users.profiles.student');
    }

    public function teacher()
    {
        $user = auth()->user();
        return view('users.profiles.teacher', [
            'status' => $user->status,
            'user' => json_decode(json_encode($user->userable)),
            'subjects' => $user->subjects,
            'subGrades' => $user->subGrades
        ]);
    }
}

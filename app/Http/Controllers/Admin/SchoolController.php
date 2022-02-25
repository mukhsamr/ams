<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        return view('admin.schools.school', [
            'teachers' => Teacher::get(['id', 'nama']),
            'school' => School::first(),
        ]);
    }

    public function school(Request $request)
    {
        $file = $request->file('logo');
        if ($file) {
            $name = 'logo.' . $file->getClientOriginalExtension();
            $file->move('storage/img/core', $name);
            $request['logo'] = $name;
        }

        try {
            School::first()->update($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'perbaharui';
        return back()->with('alert', $alert);
    }

    public function headmaster(Request $request)
    {
        $file = $request->file('signature');
        if ($file) {
            $name = 'signature.' . $file->getClientOriginalExtension();
            $file->move('storage/img/headmaster', $name);
            $request['signature'] = $name;
        }

        try {
            School::first()->update($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'perbaharui';
        return back()->with('alert', $alert);
    }
}

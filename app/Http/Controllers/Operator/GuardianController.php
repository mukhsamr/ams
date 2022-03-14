<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuardianRequest;
use App\Models\Guardian;
use App\Models\SubGrade;
use App\Models\User;
use Illuminate\Support\Str;

class GuardianController extends Controller
{
    public function index()
    {
        $guardians = Guardian::withUser()->withSubGrade()->get();

        $data = [
            'guardians' => $guardians,
            'users'     => User::select('users.id', 'nama')->where('level', '>', 3)->withTeacher()->get(),
            'subGrades' => SubGrade::all(),
        ];

        return view('operator.guardians.guardian', $data);
    }

    public function store(GuardianRequest $request)
    {
        $file = $request->file('signature');
        if ($file) {
            $name = Str::snake(str_replace('&nbsp;', ' ', User::find($request->user_id)->userable->nama)) . '.' . $file->getClientOriginalExtension();
            $file->move('storage/img/guardians', $name);
            $request['signature'] = $name;
        }

        try {
            Guardian::create($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'tambah wali kelas';
        return back()->with('alert', $alert);
    }

    public function update(GuardianRequest $request)
    {
        $file = $request->file('signature');
        if ($file) {
            $name = Str::snake(str_replace('&nbsp;', ' ', User::find($request->user_id)->userable->nama)) . '.' . $file->getClientOriginalExtension();
            $file->move('storage/img/guardians', $name);
            $request['signature'] = $name;
        }

        $guardian = Guardian::find($request->id);
        try {
            $guardian->update($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'update wali kelas';
        return back()->with('alert', $alert);
    }

    public function destroy($id)
    {
        try {
            Guardian::find($id)->delete();
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'hapus wali kelas';
        return back()->with('alert', $alert);
    }
}

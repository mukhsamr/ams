<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class SettingController extends Controller
{
    public function index()
    {
        $type = auth()->user()->userable_type;
        $return = $type == Student::class ? 'student' : 'teacher';

        return Redirect::to("setting/$return");
    }

    public function student()
    {
        //
    }

    public function teacher()
    {
        return view('users.settings.teacher', [
            'user' => auth()->user()
        ]);
    }

    public function update(UserRequest $request)
    {
        $file = $request->foto;
        if ($file) {
            $name = Str::snake($request->username) . '.' . $request->foto->extension();
            $request->file('foto')->storeAs('img/users', $name);
            $request->merge(['foto' => $name]);
        }
        try {
            User::find($request->id)->update($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            $alert['type'] = 'danger';
            report($th);
        }

        $alert['message'] = 'edit akun';
        return back()->with('alert', $alert);
    }
}

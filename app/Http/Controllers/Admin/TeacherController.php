<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Imports\TeacherImport;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $teacher = new Teacher;
        $columns = $teacher::getColumns();
        $where = in_array($request->field, ['tanggal_lahir', 'mulai_bekerja']) ? 'where' : 'whereDate';
        $teachers = $request->keyword ? $teacher->$where($request->field, 'LIKE', "%$request->keyword%") : $teacher;
        $data = [
            'teachers' => $teachers->paginate(15)->withQueryString(),
            'fields' => array_map(fn ($v) => ucwords(str_replace('_', ' ', $v)), $columns),
            'columns' => $columns,
            'field' => $request->field
        ];
        return view('admin.database.teachers.teacher', $data);
    }

    public function create()
    {
        $data = [
            'method' => 'post',
        ];
        return view('admin.database.teachers.form', $data);
    }

    public function store(TeacherRequest $request)
    {
        $file = $request->foto;
        if ($file) {
            $name = Str::snake($request->nama) . '.' . $request->foto->extension();
            $request->file('foto')->storeAs('img/teachers', $name);
            $request->merge(['foto' => $name]);
        }
        try {
            Teacher::create($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'tambah guru ' . $request->nama;
        return back()->with('alert', $alert);
    }

    public function edit(Teacher $teacher)
    {
        $data = [
            'teacher' => $teacher,
            'method' => 'put',
        ];
        return view('admin.database.teachers.form', $data);
    }

    public function update(TeacherRequest $request)
    {
        $file = $request->foto;
        if ($file) {
            $name = Str::snake($request->nama) . '.' . $request->foto->extension();
            $request->file('foto')->storeAs('img/teachers', $name);
            $request->merge(['foto' => $name]);
        }
        try {
            Teacher::find($request->id)->update($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'update guru ' . $request->nama;
        return back()->with('alert', $alert);
    }

    public function destroy(Teacher $teacher)
    {
        try {
            $teacher->delete();
            $teacher->user ? $teacher->user->delete() : '';
            $teacher->foto ? Storage::delete('img/teachers/' . $teacher->foto) : '';
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'hapus guru ' . $teacher->nama;
        return back()->with('alert', $alert);
    }

    public function import(Request $request)
    {
        $import = new TeacherImport;
        $import->import($temp = $request->import->store('temp'));

        Storage::delete($temp);
        return back()->with('import', $import);
    }
}

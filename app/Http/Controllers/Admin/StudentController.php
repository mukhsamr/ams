<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Imports\StudentImport;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $student = new Student;
        $columns = $student::getColumns();
        $students = $request->keyword ? $student->where($request->field, 'LIKE', "%$request->keyword%") : $student;
        $data = [
            'students' => $students->paginate(15)->withQueryString(),
            'fields' => array_map(fn ($v) => ucwords(str_replace('_', ' ', $v)), $columns),
            'columns' => $columns,
            'field' => $request->field
        ];
        return view('admin.database.students.student', $data);
    }

    public function create()
    {
        $data = [
            'method' => 'post',
        ];
        return view('admin.database.students.form', $data);
    }

    public function store(StudentRequest $request)
    {
        $file = $request->foto;
        if ($file) {
            $name = Str::snake($request->nama) . '.' . $request->foto->extension();
            $request->file('foto')->storeAs('img/students', $name);
            $request->merge(['foto' => $name]);
        }
        try {
            Student::create($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'tambah siswa ' . $request->nama;
        return back()->with('alert', $alert);
    }

    public function edit(Student $student)
    {
        $data = [
            'student' => $student,
            'method' => 'put',
        ];
        return view('admin.database.students.form', $data);
    }

    public function update(StudentRequest $request)
    {
        $file = $request->foto;
        if ($file) {
            $name = Str::snake($request->nama) . '.' . $request->foto->extension();
            $request->file('foto')->storeAs('img/students', $name);
            $request->merge(['foto' => $name]);
        }
        try {
            Student::find($request->id)->update($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'update siswa ' . $request->nama;
        return back()->with('alert', $alert);
    }

    public function destroy(Student $student)
    {
        try {
            $student->delete();
            $student->user ? $student->user->delete() : '';
            $student->foto ? Storage::delete('img/students/' . $student->foto) : '';
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'hapus siswa ' . $student->nama;
        return back()->with('alert', $alert);
    }

    public function import(Request $request)
    {
        $import = new StudentImport;
        $import->import($temp = $request->import->store('temp'));

        Storage::delete($temp);
        return back()->with('import', $import);
    }
}

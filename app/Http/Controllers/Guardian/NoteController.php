<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\StudentVersion;
use App\Models\SubGrade;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $subGrade = SubGrade::whereRelation('guardian', 'user_id', auth()->user()->id)->first(['id', 'sub_grade']);
        $data = [
            'notes' => Note::getNotes($subGrade),
            'subGrade' => $subGrade,
            'check' => StudentVersion::where('sub_grade_id', $subGrade->id)->doesntHave('note')->pluck('id')->toArray()
        ];
        return view('guardian.notes.note', $data);
    }

    public function update(Request $request)
    {
        try {
            Note::find($request->id)->update($request->except(['_token', '_method', 'nama']));
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'update catatan ' . $request->nama;
        return back()->with('alert', $alert);
    }

    public function check(Request $request)
    {
        try {
            Note::insert(array_map(fn ($v) => ['student_version_id' => $v], $request->student_version_id));
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'perbaharui';
        return back()->with('alert', $alert);
    }
}

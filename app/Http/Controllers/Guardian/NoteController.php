<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Note;
use App\Models\Student;
use App\Models\StudentVersion;
use App\Models\User;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $subGrade = auth()->user()->guardian->subGrade;
        $notes = Note::withStudent()
            ->whereRelation('studentVersion', 'sub_grade_id', $subGrade->id)
            ->whereRelation('studentVersion.student', 'nama', 'like', "%$request->keyword%");

        $attendances = Attendance::whereHas('user', function ($query) use ($subGrade) {
            $query->whereHasMorph('userable', [Student::class], function ($query) use ($subGrade) {
                $query->whereRelation('studentVersion', 'sub_grade_id', $subGrade->id);
            });
        })->get()->groupBy('user_id');

        $data = [
            'subGrade' => $subGrade,
            'notes' => $notes->paginate(10)->withQueryString(),
            'check' => StudentVersion::where('sub_grade_id', $subGrade->id)->doesntHave('note')->pluck('id')->toArray(),
            'keyword' => $request->keyword,
            'attendances' => $attendances->map(fn ($v) => $v->countBy('status'))
        ];
        return view('guardian.notes.note', $data);
    }

    public function edit($id)
    {
        return view('guardian.notes.modal-edit', [
            'note' => Note::withStudent()->find($id)
        ]);
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

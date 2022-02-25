<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Spiritual;
use App\Models\StudentSpiritual;
use App\Models\StudentVersion;
use App\Models\StudentVersionSpiritual;
use Illuminate\Http\Request;

class SpiritualController extends Controller
{
    public function index(Request $request)
    {
        $subGrade = auth()->user()->guardian->subGrade;
        $spirituals = StudentSpiritual::withStudent()->withSpiritual()->withSpirituals()
            ->whereRelation('studentVersion', 'sub_grade_id', $subGrade->id)
            ->whereRelation('studentVersion.student', 'nama', 'like', "%$request->keyword%");

        $data = [
            'subGrade' => $subGrade,
            'spirituals' => $spirituals->paginate(10)->withQueryString(),
            'check' => StudentVersion::where('sub_grade_id', $subGrade->id)->doesntHave('studentSpiritual')->pluck('id')->toArray(),
            'keyword' => $request->keyword
        ];

        return view('guardian.spirituals.spiritual', $data);
    }

    public function edit($id)
    {
        $spiritual = StudentSpiritual::withStudent()
            ->addSelect([
                'spirituals' => StudentVersionSpiritual::selectRaw("GROUP_CONCAT(spiritual_id SEPARATOR ',')")
                    ->whereColumn('student_version_id', 'student_spirituals.student_version_id')
                    ->limit(1),
            ])
            ->find($id);

        return view('guardian.spirituals.modal-edit', [
            'spiritual' => $spiritual,
            'lists' => Spiritual::get(),
        ]);
    }

    public function update(Request $request)
    {
        if ($request->spiritual && $request->spiritual_id) $request->merge([
            'comment' => StudentSpiritual::getComment($request->spiritual, $request->spiritual_id)
        ]);

        try {
            StudentSpiritual::find($request->id)->update($request->only(['spiritual_id', 'predicate', 'comment']));
            if ($request->spiritual) StudentVersion::find($request->student_version)->spirituals()->sync($request->spiritual);
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'update sikap spiritual';
        return back()->with('alert', $alert);
    }

    public function check(Request $request)
    {
        try {
            StudentSpiritual::insert(array_map(fn ($v) => ['student_version_id' => $v], $request->student_version_id));
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'perbaharui';
        return back()->with('alert', $alert);
    }
}

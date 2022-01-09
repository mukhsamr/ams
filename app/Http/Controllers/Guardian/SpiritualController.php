<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Spiritual;
use App\Models\StudentSpiritual;
use App\Models\StudentVersion;
use App\Models\SubGrade;
use Illuminate\Http\Request;

class SpiritualController extends Controller
{
    public function index()
    {
        $subGrade = SubGrade::whereRelation('guardian', 'user_id', auth()->user()->id)->first(['id', 'sub_grade']);
        $data = [
            'subGrade' => $subGrade,
            'spirituals' => StudentSpiritual::getSpirituals($subGrade),
            'lists' => Spiritual::all(),
            'check' => StudentVersion::where('sub_grade_id', $subGrade->id)->doesntHave('studentSpiritual')->pluck('id')->toArray()
        ];

        return view('guardian.spirituals.spiritual', $data);
    }

    public function update(Request $request)
    {
        if ($request->spiritual && $request->spiritual_id) $request->merge([
            'comment' => StudentSpiritual::getComment($request->spiritual, $request->spiritual_id)
        ]);

        try {
            StudentSpiritual::find($request->id)->update($request->only(['spiritual_id', 'predicate', 'comment']));
            if ($request->spiritual) StudentVersion::find($request->id)->spiritual()->sync($request->spiritual);
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

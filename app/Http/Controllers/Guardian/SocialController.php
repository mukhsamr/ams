<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Social;
use App\Models\StudentSocial;
use App\Models\StudentVersion;
use App\Models\SubGrade;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function index()
    {
        $subGrade = SubGrade::whereRelation('guardian', 'user_id', auth()->user()->id)->first(['id', 'sub_grade']);
        $data = [
            'subGrade' => $subGrade,
            'socials' => StudentSocial::getSocials($subGrade),
            'lists' => Social::all(),
            'check' => StudentVersion::where('sub_grade_id', $subGrade->id)->doesntHave('studentSocial')->pluck('id')->toArray()
        ];
        return view('guardian.socials.social', $data);
    }

    public function update(Request $request)
    {
        if ($request->social && $request->social_id) $request->merge([
            'comment' => StudentSocial::getComment($request->social, $request->social_id)
        ]);

        try {
            StudentSocial::find($request->id)->update($request->only(['social_id', 'predicate', 'comment']));
            if ($request->social) StudentVersion::find($request->id)->social()->sync($request->social);
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'update sikap sosial';
        return back()->with('alert', $alert);
    }

    public function check(Request $request)
    {
        try {
            StudentSocial::insert(array_map(fn ($v) => ['student_version_id' => $v], $request->student_version_id));
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'perbaharui';
        return back()->with('alert', $alert);
    }
}

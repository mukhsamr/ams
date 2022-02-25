<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Social;
use App\Models\StudentSocial;
use App\Models\StudentVersion;
use App\Models\StudentVersionSocial;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function index(Request $request)
    {
        $subGrade = auth()->user()->guardian->subGrade;
        $socials = StudentSocial::withStudent()->withSocial()->withSocials()
            ->whereRelation('studentVersion', 'sub_grade_id', $subGrade->id)
            ->whereRelation('studentVersion.student', 'nama', 'like', "%$request->keyword%");

        $data = [
            'subGrade' => $subGrade,
            'socials' => $socials->paginate(10)->withQueryString(),
            'check' => StudentVersion::where('sub_grade_id', $subGrade->id)->doesntHave('studentSocial')->pluck('id')->toArray(),
            'keyword' => $request->keyword
        ];
        return view('guardian.socials.social', $data);
    }

    public function edit($id)
    {
        $social = StudentSocial::withStudent()
            ->addSelect([
                'socials' => StudentVersionSocial::selectRaw("GROUP_CONCAT(social_id SEPARATOR ',')")
                    ->whereColumn('student_version_id', 'student_socials.student_version_id')
                    ->limit(1),
            ])
            ->find($id);

        return view('guardian.socials.modal-edit', [
            'social' => $social,
            'lists' => Social::get(),
        ]);
    }

    public function update(Request $request)
    {
        if ($request->social && $request->social_id) $request->merge([
            'comment' => StudentSocial::getComment($request->social, $request->social_id)
        ]);

        try {
            StudentSocial::find($request->id)->update($request->only(['social_id', 'predicate', 'comment']));
            if ($request->social) StudentVersion::find($request->student_version)->socials()->sync($request->social);
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

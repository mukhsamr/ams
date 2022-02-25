<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Ekskul;
use App\Models\Personality;
use App\Models\StudentEkskul;
use App\Models\StudentVersion;
use App\Models\StudentVersionEkskul;
use App\Models\StudentVersionPersonality;
use Illuminate\Http\Request;

class EkskulController extends Controller
{
    public function index(Request $request)
    {
        $subGrade = auth()->user()->guardian->subGrade;
        $ekskuls = StudentEkskul::withStudent()->withEkskuls()->withPersonalities()
            ->whereRelation('studentVersion', 'sub_grade_id', $subGrade->id)
            ->whereRelation('studentVersion.student', 'nama', 'like', "%$request->keyword%");;

        $data = [
            'subGrade' => $subGrade,
            'ekskuls' => $ekskuls->paginate(10)->withQueryString(),
            'check' => StudentVersion::where('sub_grade_id', $subGrade->id)->doesntHave('studentEkskul')->pluck('id')->toArray(),
            'keyword' => $request->keyword
        ];
        return view('guardian.ekskuls.ekskul', $data);
    }

    public function edit($id)
    {
        $ekskul = StudentEkskul::withStudent()
            ->addSelect([
                'ekskuls' => StudentVersionEkskul::selectRaw("GROUP_CONCAT(ekskul_id)")
                    ->whereColumn('student_version_id', 'student_ekskuls.student_version_id')
                    ->limit(1),
                'pre_e' => StudentVersionEkskul::selectRaw("GROUP_CONCAT(predicate)")
                    ->whereColumn('student_version_id', 'student_ekskuls.student_version_id')
                    ->limit(1),
                'personalities' => StudentVersionPersonality::selectRaw("GROUP_CONCAT(personality_id)")
                    ->whereColumn('student_version_id', 'student_ekskuls.student_version_id')
                    ->limit(1),
                'pre_p' => StudentVersionPersonality::selectRaw("GROUP_CONCAT(personality_id)")
                    ->whereColumn('student_version_id', 'student_ekskuls.student_version_id')
                    ->limit(1),
            ])
            ->find($id);

        return view('guardian.ekskuls.modal-edit', [
            'ekskul' => $ekskul,
            'ekskuls' => Ekskul::get(),
            'personalities' => Personality::get(),
        ]);
    }

    public function update(Request $request)
    {
        try {
            if ($request->ekskul) {
                $combine = array_combine($request->ekskul, $request->pre_e);
                $ekskuls = array_map(fn ($v) => ['predicate' => $v], $combine);
                StudentVersion::find($request->student_version)->ekskuls()->sync($ekskuls);
            }
            if ($request->personality) {
                $combine = array_combine($request->personality, $request->pre_p);
                $personalities = array_map(fn ($v) => ['predicate' => $v], $combine);
                StudentVersion::find($request->student_version)->personalities()->sync($personalities);
            }
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'update ekskul';
        return back()->with('alert', $alert);
    }

    public function check(Request $request)
    {
        try {
            StudentEkskul::insert(array_map(fn ($v) => ['student_version_id' => $v], $request->student_version_id));
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'perbaharui';
        return back()->with('alert', $alert);
    }
}

<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\Ledger;
use App\Models\LedgerList;
use App\Models\Score;
use App\Models\ScoreList;
use App\Models\StudentVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LedgerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $score = $user->score->load('subject', 'subGrade');
        $data = [
            'subjects' => $score->unique('subject_id'),
            'subGrades' => $score->unique(fn ($v) => $v['subject_id'] . $v['sub_grade_id']),
        ];

        return view('teacher.ledgers.ledger', $data);
    }

    public function show(Request $request)
    {
        $build = (new Ledger)->build($request->except('_token'));

        if ($build['status']) {
            $lists = new LedgerList($build['table']);

            $competences = Competence::with('score')->where([
                'type' => $request->type,
                'subject_id' => $request->subject
            ])->whereRelation('score', 'sub_grade_id', $request->sub_grade)->get();

            $ledger = Ledger::where('name', $build['table'])->first();
            $kkm = $competences->avg('kkm');

            $prev = url()->previous();
            $role = Str::after($prev, url('/') . '/');
            session()->put([
                $role => $ledger,
                'ledger_' . $role => $prev,
            ]);
            $data = [
                'lists' => $lists->get()->load('studentVersion.student')->sortBy(fn ($q) => $q->studentVersion->student->nama),
                'fields' => $lists->getColumns(),
                'type' => $request->type,
                'ledger' => $ledger,
                'competences' => $competences,
                'kkm' => $kkm,
                'interval' => (100 - $kkm) / 3
            ];

            return view('teacher.ledgers.table', $data);
        }
    }

    public function load(Request $request)
    {
        $lists = new LedgerList($request->name);

        $check = array_diff(StudentVersion::where('sub_grade_id', $request->sub_grade)->pluck('id')->toArray(), $lists->pluck('student_version_id')->toArray());
        if ($check) $this->check($check, $lists);

        $scores = Score::with('competence')->where([
            'subject_id' => $request->subject,
            'sub_grade_id' => $request->sub_grade,
        ])->whereRelation('competence', 'type', $request->type)->get();

        $insert = [];
        $competences = [];
        foreach ($scores as $score) {
            $competence = $score->competence;

            $table = (new ScoreList($score->name))->pluck($request->type == 1 ? 'nilai_bc' : 'nilai_akhir', 'student_version_id');
            $competences[] = $competence;
            $insert[str_replace('.', '_', $competence->format_competence)] = $table->toArray();
        }

        $lists->updateColumns($insert, $request->type, collect($competences));

        return back();
    }

    public function update(Request $request)
    {
        $lists = new LedgerList($request->name);

        foreach ($request->pas as $id => $value) {
            try {
                $lists->where('student_version_id', $id)->update(['pas' => $value]);
                $alert['type'] = 'success';
            } catch (\Exception $e) {
                report($e);
                $alert['type'] = 'danger';
            }
        }
        $alert['message'] = 'update nilai pas';

        return back()->with('alert', $alert);
    }

    public function check(array $insert, $lists)
    {
        try {
            $lists->insert(array_map(fn ($v) => ['student_version_id' => $v], $insert));
        } catch (\Throwable $e) {
            report($e);
        }
    }
}

<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\Ledger;
use App\Models\LedgerList;
use App\Models\Score;
use App\Models\ScoreList;
use App\Models\SubGrade;
use App\Models\Subject;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $subGrades = SubGrade::all();
        $subGrade = $request->subGrade ?? ($subGrades->first() ? $subGrades->first()->id : null);

        if ($subGrade) {
            $scores = Score::where('sub_grade_id', $subGrade)
                ->select('name', 'subjects.id as subject', 'competence', 'type')
                ->withSubject()
                ->withCompetence()
                ->get();

            $progress = [];
            $tuntas = [];
            foreach ($scores as $score) {
                $list = new ScoreList($score->name);

                $keterangan = $list->pluck('keterangan');
                // Progress
                $filter = $keterangan->filter(fn ($v) => $v !== null);
                if ($bool = $filter->isNotEmpty()) {
                    $progress[$score->subject][$score->type][] = $bool;
                }

                // Tuntas
                $tuntas[$score->subject]['success_' . $score->type] ??= 0;
                $tuntas[$score->subject]['success_' . $score->type] += $keterangan->sum();

                $tuntas[$score->subject]['count_' . $score->type] ??= 0;
                $tuntas[$score->subject]['count_' . $score->type] += count($keterangan, COUNT_RECURSIVE);
            }

            $subjects = Subject::whereRelation('competence', 'grade_id', $subGrades->find($subGrade)->grade_id)->withCount([
                'competence as kd_3' => function ($query) use ($subGrades, $subGrade) {
                    $query->where('grade_id', $subGrades->find($subGrade)->grade_id)->where('type', 1);
                },
                'competence as kd_4' => function ($query) use ($subGrades, $subGrade) {
                    $query->where('grade_id', $subGrades->find($subGrade)->grade_id)->where('type', 2);
                }
            ])->get();

            foreach ($subjects as $kd) {
                // Progress
                $kd['progress_kd3'] = ($progress[$kd->id][1] ?? 0) ? round((count($progress[$kd->id][1]) / $kd->kd_3) * 100) : 0;
                $kd['progress_kd4'] = ($progress[$kd->id][2] ?? 0) ? round((count($progress[$kd->id][2]) / $kd->kd_4) * 100) : 0;

                // Tuntas
                $kd['tuntas_3'] = ($tuntas[$kd->id]['success_1'] ?? 0) ? round(($tuntas[$kd->id]['success_1'] / $tuntas[$kd->id]['count_1']) * 100) : 0;
                $kd['tuntas_4'] = ($tuntas[$kd->id]['success_2'] ?? 0) ? round(($tuntas[$kd->id]['success_2'] / $tuntas[$kd->id]['count_2']) * 100) : 0;
            }
        }

        $data = [
            'subGrades' => $subGrades,
            'selected' => $subGrade,
            'subjects' => $subjects ?? [],
        ];

        return view('operator.homes.home', $data);
    }

    public function info($subGrade, $subject)
    {
        $ledgers = Ledger::where('sub_grade_id', $subGrade)
            ->where('subject_id', $subject)
            ->get();

        if ($ledgers->isNotEmpty()) {
            $first = $ledgers->first();
            $list = new LedgerList($first->name);
            $column = $list->getFieldsLedger($first->type);

            $score = $list->select($column->toArray());
            if ($ledgers->count() > 1) {
                $last = $ledgers->last();
                $column = (new LedgerList($last->name))->getFieldsLedger($last->type);
                $score->addSelect($column->toArray())->join($last->name, "$last->name.student_version_id", '=', "$first->name.student_version_id");
            }
            $scores = $score->withStudents()->orderBy('nama')->get();
        }
        $competences = Competence::where('grade_id', SubGrade::find($subGrade)->grade_id)->where('subject_id', $subject)->get(['competence', 'type', 'kkm']);

        $data = [
            'subject' => Subject::find($subject),
            'scores' => $scores ?? [],
            'competences' => $competences,
        ];
        return view('operator.homes.info', $data);
    }
}

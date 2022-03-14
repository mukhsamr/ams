<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\Ledger;
use App\Models\LedgerList;
use App\Models\Subject;

class GradeLedger extends Controller
{
    public function index()
    {
        $subGrade = auth()->user()->guardian->subGrade;

        $ledgers = Ledger::where('sub_grade_id', $subGrade->id)->orderByRaw('type, subject_id')->get()->groupBy('type');

        if ($ledgers->isNotEmpty()) {
            ['1' => $bc3, '2' => $bc4] = $ledgers;

            if ($bc3) {
                $first = $bc3->first();
                $table = (new LedgerList($first->name))->select("$first->name.hpa as $first->subject_id");
                foreach ($bc3->skip(1) as $ledger) {
                    $lists = $table
                        ->join($ledger->name, "$first->name.student_version_id", "$ledger->name.student_version_id")
                        ->addSelect("$ledger->name.hpa as $ledger->subject_id");
                }

                $lists->withStudents();
                $obj = $lists->get();
                foreach ($obj as $v) {
                    $collect = collect($v->getAttributes());
                    $score = $collect->slice(0, -1);
                    $v->avg = round($score->avg());
                    $v->sum = $score->sum();
                }

                $sort = $obj->sortByDesc(fn ($v) => intval($v->sum));
                $i = 1;
                foreach ($sort as $s) {
                    $s->rank = $i++;
                }

                $ledger3 = $sort->sortBy(fn ($v) => $v->nama);
            }

            if ($bc4) {
                $first = $bc4->first();
                $table = (new LedgerList($first->name))->select("$first->name.rph as $first->subject_id");
                foreach ($bc4->skip(1) as $ledger) {
                    $lists = $table
                        ->join($ledger->name, "$first->name.student_version_id", "$ledger->name.student_version_id")
                        ->addSelect("$ledger->name.rph as $ledger->subject_id");
                }

                $lists->withStudents();
                $obj = $lists->get();
                foreach ($obj as $v) {
                    $collect = collect($v->getAttributes());
                    $score = $collect->slice(0, -1);
                    $v->avg = round($score->avg());
                    $v->sum = $score->sum();
                }

                $sort = $obj->sortByDesc(fn ($v) => intval($v->sum));
                $i = 1;
                foreach ($sort as $s) {
                    $s->rank = $i++;
                }

                $ledger4 = $sort->sortBy(fn ($v) => $v->nama);
            }
        }

        $data = [
            'subGrade' => $subGrade,
            'ledger3' => $ledger3 ?? [],
            'ledger4' => $ledger4 ?? [],
            'subjects' => Subject::where('raport', 1)->withKKM()->get()
        ];
        return view('guardian.gradeLedgers.gradeLedger', $data);
    }
}

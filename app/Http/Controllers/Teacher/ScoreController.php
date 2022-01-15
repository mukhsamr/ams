<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScoreRequest;
use App\Models\Score;
use App\Models\ScoreColumn;
use App\Models\ScoreList;
use App\Models\StudentVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ScoreController extends Controller
{
    /**
     * Display a view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $scores = $user->score;

        $data = [
            'user' => $user->load(['subGrade.grade', 'competence.grade', 'subject']),
            'subjects' => $scores->unique('subject_id')->load('subject'),
            'subGrades' => $scores->unique(fn ($v) => $v['subject_id'] . $v['sub_grade_id'])->load('subGrade'),
            'competences' => $scores->unique(fn ($v) => $v['subject_id'] . $v['sub_grade_id'] . $v['competence_id'])
                ->load('competence')
                ->sortBy(fn ($q) => $q->competence->competence . $q->competence->type)
        ];
        return view('teacher.scores.score', $data);
    }

    /**
     * Build table score.
     * Store a newly created resource in scores.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function build(ScoreRequest $request)
    {
        $build = (new Score)->build($request->toArray());

        if ($build['status'] === 'success') {
            foreach (StudentVersion::where('sub_grade_id', $request->sub_grade)->pluck('id') as $id) {
                $insert[] = DB::table($build['table'])->insert(['student_version_id' => $id]);
            }
            $alert['type'] = 'success';
        } elseif ($build['status'] === 'warning') {
            $alert['type'] = 'warning';
        } else {
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'membuat nilai';

        return back()->with('alert', $alert);
    }

    /**
     * Search list of table.
     * Set session table
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function search(Request $request)
    {
        $table = Score::where([
            'subject_id'    => $request->subject,
            'sub_grade_id'  => $request->sub_grade,
            'competence_id' => $request->competence,
        ])->first();

        $prev = url()->previous();
        $role = Str::after($prev, url('/') . '/');
        if ($table) session()->put([
            $role => $table,
            'score_' . $role => $prev,
        ]);

        return back();
    }

    /**
     * Show table by ajax.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function show(Request $request)
    {
        $scores = Score::with(['subject', 'subGrade', 'competence'])->where('name', $request->name)->first();
        $scoreList = new ScoreList($request->name);
        $lists = $scoreList->get();

        $type = $scores->competence->type;
        $fields = Schema::getColumnListing($request->name);
        $data = [
            'scores'    => $scores,
            'lists'     => $lists->load(['studentVersion.student'])->sortBy(fn ($q) => $q->studentVersion->student->nama),
            'fields'    => array_slice($fields, 2),
            'fieldsScore'   => $scoreList->getFieldsScore($type, $fields),
            'scoreColumns'  => ScoreColumn::getNameOnly($type),
            'name'  => $request->name,
            'type'  => $type,
            'check' => StudentVersion::where('sub_grade_id', $request->sub_grade_id)
                ->whereNotIn('id', $lists->pluck('student_version_id')->toArray())
                ->pluck('id')->toArray()
        ];
        return view('teacher.scores.table', $data);
    }

    /**
     * Show the table for editing.
     * By ajax
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $field = $request->index ? $request->column . '_' . $request->index : $request->column;

        $table = $request->table;
        $data = [
            'table' => $request->table,
            'field' => $field,
            'scores' => (new ScoreList($table))->getColumn($field)->load('studentVersion.student')->sortBy(fn ($q) => $q->studentVersion->student->nama),
            'type' => $request->type
        ];
        return view('teacher.scores.table-edit', $data);
    }

    /**
     * Update scores.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $table = new ScoreList($request->table);
        $column = $request->field;
        $updated = $table->updateScores($request->$column, $column, $request->type);

        $alert = [
            'message' => 'update ' . ucwords(str_replace('_', ' ', $column)) . '.',
            'type'  => in_array(false, $updated) ? 'danger' : 'success'
        ];
        return back()->with('alert', $alert);
    }

    /**
     * Remove column
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
        $scoreList = new ScoreList($request->table);
        $removed = $scoreList->removeColumn($request->column, $request->type);
        $alert = [
            'message' => 'hapus ' . ucwords(str_replace('_', ' ', $request->column)) . '.',
            'type'  => in_array(false, $removed) ? 'danger' : 'success'
        ];
        return back()->with('alert', $alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $table
     * @return \Illuminate\Http\Response
     */
    public function drop($table)
    {
        $drop = ScoreList::dropTable($table);
        if ($drop) {
            try {
                Score::where('name', $table)->delete();
                session()->forget('table');
                $delete = true;
            } catch (\Exception $e) {
                report($e);
                $delete = false;
            }
        } else {
            $delete = false;
        }

        $alert = [
            'message' => 'hapus nilai.',
            'type'  => $delete ? 'success' : 'danger'
        ];
        return back()->with('alert', $alert);
    }

    public function check(Request $request, $table)
    {
        try {
            (new ScoreList($table))->setTable($table)->insert(array_map(fn ($v) => ['student_version_id' => $v], $request->student_id));
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'perbaharui';
        return back()->with('alert', $alert);
    }
}

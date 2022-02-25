<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScoreRequest;
use App\Models\Score;
use App\Models\ScoreColumn;
use App\Models\ScoreList;
use App\Models\StudentVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ScoreController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $scores = $user->scores();
        $data = [
            'subjects' => $scores->unique('subject_id'),
            'subGrades' => $scores->unique(fn ($v) => $v->subject_id . $v->sub_grade_id),
            'competences' => $scores->unique(fn ($v) => $v->subject_id . $v->sub_grade_id . $v->competence_id),
        ];
        return view('teacher.scores.score', $data);
    }

    public function create()
    {
        $user = auth()->user();
        return view('teacher.scores.modal-create', [
            'subjects' => $user->subjects,
            'subGrades' => $user->subGrades,
            'competences' => $user->competences
        ]);
    }
    public function build(ScoreRequest $request)
    {
        $build = (new Score)->build($request->toArray());

        if ($build['status'] === 'success') {
            $score = new ScoreList($build['name']);
            $students = StudentVersion::where('sub_grade_id', $request->sub_grade)->pluck('id')->toArray();
            $score->insert(array_map(fn ($v) => ['student_version_id' => $v], $students));

            $session = [
                'subject_id'    => $request->subject,
                'sub_grade_id'  => $request->sub_grade,
                'competence_id' => $request->competence,
            ];
            session()->put($session);

            $alert['type'] = 'success';
        } elseif ($build['status'] === 'warning') {
            return back()->withErrors(['Nilai sudah ada']);
        } else {
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'membuat nilai';
        return back()->with('alert', $alert);
    }

    public function search(Request $request)
    {
        $prev = url()->previous();
        $role = Str::after($prev, url('/') . '/');

        $table = Score::firstWhere([
            'subject_id'    => $request->subject,
            'sub_grade_id'  => $request->sub_grade,
            'competence_id' => $request->competence,
        ]);

        if ($table) session()->put([
            $role => $table,
            'score_' . $role => $prev
        ]);

        return back();
    }

    public function show(Request $request)
    {
        $scores = Score::with([
            'subject:id,subject',
            'subGrade:id,sub_grade,name',
            'competence'
        ])->firstWhere('name', $request->name);

        $lists = new ScoreList($request->name);

        $type = $scores->competence->type;
        $fields = Schema::getColumnListing($request->name);
        $data = [
            'scores'    => $scores,
            'students'  => $lists->withStudents($request->name)->get(),
            'fields'    => array_slice($fields, 2),
            'fieldsScore'   => $lists->getFieldsScore($type, $fields),
            'scoreColumns'  => ScoreColumn::getNameOnly($type),
            'name'  => $request->name,
            'type'  => $type,
            'check' => StudentVersion::where('sub_grade_id', $request->sub_grade_id)
                ->whereNotIn('id', $lists->pluck('student_version_id')->toArray())
                ->pluck('id')->toArray()
        ];
        return view('teacher.scores.table', $data);
    }

    public function edit(Request $request)
    {
        $field = $request->index ? $request->column . '_' . $request->index : $request->column;

        $table = $request->table;
        $data = [
            'table' => $table,
            'field' => $field,
            'scores' => (new ScoreList($table))->withStudents($request->name)->get(),
            'type' => $request->type
        ];
        return view('teacher.scores.table-edit', $data);
    }

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

    public function drop($table)
    {
        $drop = ScoreList::dropTable($table);
        if ($drop) {
            try {
                Score::where('name', $table)->delete();
                session()->forget(['subject_id', 'sub_grade_id', 'competence_id']);
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
        $students = array_map(fn ($v) => ['student_version_id' => $v], $request->student_id);
        try {
            (new ScoreList($table))->insert($students);
            $alert['type'] = 'success';
        } catch (\Throwable $e) {
            report($e);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'perbaharui';
        return back()->with('alert', $alert);
    }
}

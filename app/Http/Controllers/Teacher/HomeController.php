<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ScoreList;
use App\Models\StudentVersion;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $subject = $user->subjects;
        $subGrade = $user->subGrades;

        $subjectId = $request->subject ?? $subject->first()->id ?? null;
        $subGradeId = $request->subGrade ?? $subGrade->first()->id ?? null;
        $scores = $user->scores()
            ->where('subject_id', $subjectId)
            ->where('sub_grade_id', $subGradeId);

        $finished = [];
        $recaps = [];
        $competences = [];

        $students = StudentVersion::withStudent()->where('sub_grade_id', $subGradeId)->get();
        foreach ($scores as $score) {
            $nilai = $score->type == 1 ? 'nilai_bc' : 'nilai_akhir';

            $lists = (new ScoreList($score->name))->get(['student_version_id', $nilai, 'keterangan']);
            $competence = competence($score);
            $competences[] = $competence;
            $finished[$competence] = [
                'success' => $lists->whereStrict('keterangan', 1)->count(),
                'fail' => $lists->whereStrict('keterangan', 0)->count()
            ];

            foreach ($lists as $list) {
                $recaps[$students->find($list->student_version_id)->nama][$competence] = [
                    'nilai' => $list->$nilai,
                    'status' => $list->getRawOriginal('keterangan')
                ];
            }
        }

        ksort($recaps);
        $json = [];
        foreach ($finished as $key => $value) {
            $json[] = [
                'key' => $key,
                'data' => $value
            ];
        }

        $data = [
            'subjects' => $subject,
            'subGrades' => $subGrade,
            'selected' => [
                'subject' => $subjectId,
                'subGrade' => $subGradeId
            ],
            'finished' => $finished,
            'json' => json_encode($json),
            'competences' => $competences,
            'recaps' => $recaps,
        ];

        return view('teacher.homes.home', $data);
    }
}

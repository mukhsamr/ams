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
        $subject = $user->load('subject')->subject;
        $subGrade = $user->load('subGrade')->subGrade;

        $subjectId = $request->subject ?? $subject->first()->id ?? null;
        $subGradeId = $request->subGrade ?? $subGrade->first()->id ?? null;
        $scores = $user->score->load('competence:id,competence,type')
            ->where('subject_id', $subjectId)
            ->where('sub_grade_id', $subGradeId)
            ->sortBy(fn ($query) => $query->competence->competence . $query->competence->type);

        $finished = [];
        $recaps = [];
        $competences = [];

        $students = StudentVersion::with('student:id,nama')->where('sub_grade_id', $subGradeId)->get();
        foreach ($scores as $score) {
            $nilai = $score->competence->type == 1 ? 'nilai_bc' : 'nilai_akhir';

            $lists = (new ScoreList($score->name))->get(['student_version_id', $nilai, 'keterangan']);
            $competence = $score->competence->format_competence;
            $competences[] = $competence;
            $finished[$competence] = [
                'success' => $lists->where('keterangan', 1)->count(),
                'fail' => $lists->where('keterangan', 0)->count()
            ];

            foreach ($lists as $list) {
                $recaps[$students->find($list->student_version_id)->student->nama][$competence] = [
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
            'selected' => [
                'subject' => $subjectId,
                'subGrade' => $subGradeId
            ]
        ];

        return view('teacher.homes.home', $data);
    }
}

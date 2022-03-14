<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Ledger;
use App\Models\LedgerList;
use App\Models\Note;
use App\Models\Raport;
use App\Models\Student;
use App\Models\StudentSocial;
use App\Models\StudentSpiritual;
use App\Models\StudentVersion;
use App\Models\SubGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RaportController extends Controller
{
    public function pts(Request $request)
    {
        $selected = $request->subGrade;
        $subGrade = $selected ? SubGrade::find($selected) : SubGrade::first();
        $students = StudentVersion::where('sub_grade_id', $subGrade->id ?? null)->withStudent()->get(['id', 'nama', 'student_id']);

        $ledgers = Ledger::where('sub_grade_id', $subGrade->id ?? null)
            ->withSubject()
            ->whereRelation('subject', 'raport', true)
            ->orderBy('subject_id')
            ->get()
            ->groupBy('subject');


        $raports = [];
        $nama = $request->nama;
        $student = $students->find($nama);
        if ($student) {
            foreach ($ledgers as $subject => $ledger) {
                $lists = [];
                foreach ($ledger as $l) {
                    $list = new LedgerList($l->name);
                    $column = $list->getFieldsLedger($l->type)->toArray();
                    if ($column) {
                        $score = $list->select($column)
                            ->where('student_version_id', $nama)
                            ->first();

                        $lists[] = $score ? $score->getAttributes() : [];
                    }
                }
                $raports[$subject] = collect($lists)->collapse()->groupBy(fn ($v, $k) => Str::after($k, '_'), true)->sortKeys();
            }
        }

        $data = [
            'setting' => Raport::firstWhere('type', 'pts'),
            'subGrade' => $subGrade,
            'student' => $student ? $student->nama : null,
            'students' => $students,
            'columns' => ['1', '2', '3', '4', '5'],
            'raports' => $raports,
            'nama' => $request->nama,
            'selected' => $selected,
            'subGrades' => SubGrade::all(),
        ];
        return view('operator.raports.pts', $data);
    }

    public function k13(Request $request)
    {
        $selected = $request->subGrade;
        $subGrade = $subGrade = $selected ? SubGrade::find($selected) : SubGrade::first();
        $students = StudentVersion::where('sub_grade_id', $subGrade->id ?? null)->withStudent()->get(['id', 'nama']);
        $student_id = $request->nama;
        $student = $students->firstWhere('student_id', $student_id);
        if ($student) {

            // Sikap
            $spiritual = StudentSpiritual::select('comment', 'predicate')
                ->whereRelation('studentVersion', 'student_id', $student_id)
                ->withCalled()
                ->first();

            $social = StudentSocial::select('comment', 'predicate')
                ->whereRelation('studentVersion', 'student_id', $student_id)
                ->withCalled()
                ->first();

            $sikap = [
                'Spiritual' => $spiritual,
                'Sosial' => $social,
            ];

            // ====

            $ledgers = Ledger::with('subject:id,subject,local_content')
                ->whereRelation('subject', 'raport', true)
                ->orderBy('subject_id')
                ->withKKM()
                ->get(['name', 'subject_id']);

            // Pengetahuan
            $scores = [];
            $ledgers_3 = $ledgers->where('type', 1);
            foreach ($ledgers_3 as $ledger) {
                $list = new LedgerList($ledger->name);
                $score = $list->select('hpa', 'pre', 'deskripsi')
                    ->whereRelation('studentVersion', 'student_id', $student_id)
                    ->first();
                if ($score) {
                    $score['local'] = $ledger->subject->local_content ? 'y' : 'n';
                    $score['kkm'] = ceil($ledger->kkm);
                    $scores[$ledger->subject->subject] = $score;
                }
            }
            $pengetahuan = collect($scores)->groupBy('local', true)->sortKeys();

            // Keterampilan
            $scores = [];
            $ledgers_4 = $ledgers->where('type', 2);
            foreach ($ledgers_4 as $ledger) {
                $list = new LedgerList($ledger->name);
                $score = $list->select('rph', 'pre', 'deskripsi')
                    ->whereRelation('studentVersion', 'student_id', $student_id)
                    ->first();
                if ($score) {
                    $score['local'] = $ledger->subject->local_content ? 'y' : 'n';
                    $score['kkm'] = ceil($ledger->kkm);

                    $scores[$ledger->subject->subject] = $score;
                }
            }
            $keterampilan = collect($scores)->groupBy('local', true)->sortKeys();

            // ====

            // Ekskul
            $ekskul = StudentVersion::firstWhere('student_id', $student_id)->ekskuls()->withPivot('predicate')->get();

            // Absen
            $attendance = Attendance::whereHas('user', function ($query) use ($student_id) {
                $query->whereHasMorph('userable', [Student::class])->where('userable_id', $student_id);
            })->selectRaw('status, COUNT(id) as count')
                ->groupBy('status')
                ->get();

            $absen = [
                'Sakit' => $attendance->where('status', 'Sakit')->first(),
                'Izin' => $attendance->where('status', 'Izin')->first(),
                'Alpha' => $attendance->where('status', 'Alpha')->first(),
            ];

            // Catatan
            $catatan = Note::whereRelation('studentVersion', 'student_id', $student_id)->first();

            // Kepribadian
            $kepribadian = StudentVersion::firstWhere('student_id', $student_id)->personalities()->withPivot('predicate')->get();
        }

        $data = [
            'setting' => Raport::firstWhere('type', 'k13'),
            'subGrades' => SubGrade::all(),
            'subGrade' => $subGrade,
            'student' => $student ? $student->nama : null,
            'students' => $students,
            'nama' => $student_id,
            'sikap' => $sikap ?? [],
            'pengetahuan' => $pengetahuan ?? [],
            'keterampilan' => $keterampilan ?? [],
            'ekskul' => $ekskul ?? [],
            'absen' => $absen ?? [],
            'catatan' => $catatan ?? [],
            'kepribadian' => $kepribadian ?? [],
            'selected' => $selected,
        ];
        return view('operator.raports.k13', $data);
    }
}

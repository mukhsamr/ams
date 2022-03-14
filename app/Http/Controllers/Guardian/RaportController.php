<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Guardian;
use App\Models\Ledger;
use App\Models\LedgerList;
use App\Models\Note;
use App\Models\Raport;
use App\Models\School;
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
        $subGrade = auth()->user()->guardian->subGrade;
        $students = StudentVersion::where('sub_grade_id', $subGrade->id)->withStudent()->get(['id', 'nama', 'student_id']);

        $ledgers = Ledger::where('sub_grade_id', $subGrade->id)
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
            'columns' => ['1', '2', '3', '4', '5', '6'],
            'raports' => $raports,
            'nama' => $request->nama,
        ];
        return view('guardian.raports.pts', $data);
    }

    public function k13(Request $request)
    {
        $subGrade = auth()->user()->guardian->subGrade;
        $students = StudentVersion::where('sub_grade_id', $subGrade->id)->withStudent()->get(['id', 'nama']);
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
        ];
        return view('guardian.raports.k13', $data);
    }

    public function setting(Request $request)
    {
        $request['background'] ??= null;
        try {
            Raport::firstWhere('type', $request->type)->update($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'perbaharui setelan raport ' . strtoupper($request->type);
        return back()->with('alert', $alert);
    }

    public function pdf_pts(Request $request)
    {
        $ledgers = Ledger::where('sub_grade_id', $request->subGrade)
            ->withSubject()
            ->whereRelation('subject', 'raport', true)
            ->orderBy('subject_id')
            ->get()
            ->groupBy('subject');

        $raports = [];
        $nama = $request->nama;
        $student = Student::whereRelation('studentVersion', 'id', $nama)->first();
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
                $raports[$subject] = collect($lists)->collapse()->groupBy(fn ($v, $k) => Str::after($k, '_'), true)->sortKeys();;
            }
        }

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->curlAllowUnsafeSslRequests = true;

        $html = view('exports.raports.pts', [
            'student' => $student,
            'subGrade' => SubGrade::find($request->subGrade),
            'version' => session('version'),
            'columns' => ['1', '2', '3', '4', '5'],
            'raports' => $raports,
            'setting' => Raport::firstWhere('type', 'pts'),
            'school' => School::first(),
            'guardian' => Guardian::where('sub_grade_id', $request->subGrade)->withUser()->first(),
        ]);

        $file = 'Raport PTS ' . str_replace('&nbsp;', ' ', $student->nama) . '.pdf';
        $mpdf->WriteHTML($html);
        $mpdf->Output($file, 'D');
    }

    public function pdf_k13(Request $request)
    {
        $student_id = $request->nama;
        $student = Student::find($student_id);

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

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->curlAllowUnsafeSslRequests = true;

        $html = view('exports.raports.k13', [
            'setting' => Raport::firstWhere('type', 'k13'),
            'subGrade' => SubGrade::find($request->subGrade),
            'version' => session('version'),
            'school' => School::first(),
            'guardian' => Guardian::where('sub_grade_id', $request->subGrade)->withUser()->first(),

            'student' => $student,
            'nama' => $student_id,
            'sikap' => $sikap ?? [],
            'pengetahuan' => $pengetahuan ?? [],
            'keterampilan' => $keterampilan ?? [],
            'ekskul' => $ekskul ?? [],
            'absen' => $absen ?? [],
            'catatan' => $catatan ?? [],
            'kepribadian' => $kepribadian ?? [],
        ]);

        $file = 'Raport K13 ' . str_replace('&nbsp;', ' ', $student->nama) . '.pdf';
        $mpdf->WriteHTML($html);
        $mpdf->Output($file, 'D');
    }
}

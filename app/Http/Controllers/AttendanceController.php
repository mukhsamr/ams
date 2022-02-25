<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AttendanceController extends Controller
{
    public function index()
    {
        $type = auth()->user()->userable_type;
        $return = $type == Student::class ? 'student' : 'teacher';

        return Redirect::to("attendance/$return");
    }

    public function student()
    {
        //
    }

    public function teacher()
    {
        $attendances = auth()->user()->attendances()->orderBy('date', 'desc');

        return view('users.attendances.teacher', [
            'attendances' => $attendances->paginate(10),
            'info' => $attendances->select('status')
                ->selectRaw('count(*) as count')
                ->groupBy('status')
                ->orderBy('status')->get(),
        ]);
    }

    public function qrcode(Request $request)
    {
        if (!($setting = AttendanceSetting::firstWhere('qrcode', $request->qrcode))) return [
            'type' => 'danger',
            'message' => 'QrCode tidak valid'
        ];

        $status = date('H:i:s') > $setting->end ? 'Terlambat' : 'Tepat Waktu';
        $attendance = Attendance::where([
            'user_id' => $request->id,
            'date' => date('Y-m-d')
        ])->firstOr(function () use ($request, $status) {
            return User::find($request->id)->attendances()->create([
                'date' => date('Y-m-d'),
                'hours' => date('H:i:s'),
                'status' => $status,
                'version_id' => session('version')->id,
            ]);
        });
        session()->put('isAbsen', true);

        return [
            'confirm' => true,
            'name' => $attendance->user->userable->nama,
            'date' => $attendance->hours,
            'status' => $status == 'Terlambat' ? '<strong class="text-warning">Terlambat</strong>' : '<strong class="text-success">Tepat Waktu</strong>'
        ];
    }

    public function barcode(Request $request)
    {
        if ($user = User::firstWhere('username', $request->username)) {
            $status = date('H:i:s') > AttendanceSetting::first()->end ? 'Terlambat' : 'Tepat Waktu';
            $nama = $user->userable->nama;
            Attendance::where([
                'user_id' => $user->id,
                'date' => date('Y-m-d')
            ])->firstOr(function () use ($user, $status) {
                return $user->attendances()->create([
                    'date' => date('Y-m-d'),
                    'hours' => date('H:i:s'),
                    'status' => $status,
                    'version_id' => session('version')->id,
                ]);
            });

            return back()->with('alert', [
                'type' => 'success',
                'message' => 'konfirmasi ', $nama
            ]);
        } else {
            return back()->with('alert', [
                'type' => 'danger',
                'message' => 'username tidak ditemukan'
            ]);
        }
    }

    public function update(Request $request)
    {
        $version = session('version')->id;
        try {
            foreach ($request->student as $student) {
                $student['version_id'] = $version;
                Attendance::updateOrCreate(['id' => $student['id']], $student);
            }
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'ubah absen';
        return back()->with('alert', $alert);
    }
}

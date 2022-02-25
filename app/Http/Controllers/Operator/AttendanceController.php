<?php

namespace App\Http\Controllers\Operator;

use App\Exports\AttendanceExport;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\Calendar;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AttendanceController extends Controller
{
    public function student(Request $request)
    {
        $filter = $request->filter ?? date('Y-m-d');
        $setting = AttendanceSetting::student();

        $holiday = Calendar::isHoliday($filter, $setting);
        $attendances = Attendance::select('attendances.*', 'users.id as user_id', 'students.nama')->withStudent($filter);
        $qrcode = QrCode::size(150)->generate($setting->qrcode);
        $data = [
            'filtered' => $filter,
            'holiday' => $holiday,
            'setting' => $setting,
            'qrcode' => $qrcode,
            'attendances' => $holiday ? null : $attendances->orderBy('hours')->paginate(10)->withQueryString()
        ];
        return view('operator.attendances.student', $data);
    }

    // ===

    public function teacher(Request $request)
    {
        $filter = $request->filter ?? date('Y-m-d');
        $setting = AttendanceSetting::teacher();

        $holiday = Calendar::isHoliday($filter, $setting);
        $attendances = Attendance::select('attendances.*', 'users.id as user_id', 'teachers.nama')->withTeacher($filter);
        $qrcode = QrCode::size(150)->generate($setting->qrcode);
        $data = [
            'filtered' => $filter,
            'holiday' => $holiday,
            'setting' => $setting,
            'qrcode' => $qrcode,
            'attendances' => $holiday ? null : $attendances->orderBy('hours')->paginate(10)->withQueryString()
        ];
        return view('operator.attendances.teacher', $data);
    }

    // ===

    public function setting(Request $request)
    {
        $request->sat ??= $request->merge(['sat' => null]);
        $request->sun ??= $request->merge(['sun' => null]);

        $type = $request->type;
        $setting = AttendanceSetting::$type();
        try {
            $setting->update($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'mengubah jam hadir';
        return back()->with('alert', $alert);
    }

    public function qrcode($type)
    {
        $path = storage_path('app/public/img/qrcode.png');
        QrCode::format('png')->size(500)->generate(AttendanceSetting::$type()->qrcode, $path);

        return response()->download($path);
    }

    public function updateQrcode($type)
    {
        try {
            AttendanceSetting::$type()->update(['qrcode' => bcrypt('nqm' . time() . 'education')]);
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'perbaharui qrcode';
        return back()->with('alert', $alert);
    }

    public function update(Request $request)
    {
        $request->merge(['version_id' => session('version')->id]);
        try {
            Attendance::updateOrCreate(['id' => $request->id], $request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            dd();
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'ubah absen';
        return back()->with('alert', $alert);
    }

    public function studentExport(Request $request)
    {
        $name = 'Absensi Siswa ' . formatDate($request->start) . ' sampai ' . formatDate($request->end) . '.xlsx';
        return Excel::download(new AttendanceExport($request, 'students'), $name);
    }

    public function teacherExport(Request $request)
    {
        $name = 'Absensi Guru ' . formatDate($request->start) . ' sampai ' . formatDate($request->end) . '.xlsx';
        return Excel::download(new AttendanceExport($request, 'teachers'), $name);
    }
}

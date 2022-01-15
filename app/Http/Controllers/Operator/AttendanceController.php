<?php

namespace App\Http\Controllers\Operator;

use App\Exports\AttendanceExport;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\Calendar;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter ?? date('Y-m-d');
        $setting = AttendanceSetting::first();

        $holiday = Calendar::isHoliday($filter, $setting);
        if (!$holiday) {
            $type = Teacher::class;
            $attendances = Attendance::whereRelation('user', 'userable_type', $type)->whereDate('date', $filter)->get();
            $users = User::where('userable_type', $type)->get();

            foreach ($users as $user) {
                if ($attendances->firstWhere('user_id', $user->id)) continue;

                $attendances->push(new Attendance([
                    'date' => $filter,
                    'user_id' => $user->id,
                ]));
            }
        }

        $qrcode = QrCode::size(150)->generate($setting->qrcode);
        $data = [
            'holiday' => $holiday,
            'filtered' => $filter,
            'setting' => $setting,
            'qrcode' => $qrcode,
            'attendances' => $holiday ? '' : $attendances->load('user.userable:id,nama')
        ];
        return view('operator.attendances.attendance', $data);
    }

    public function setting(Request $request)
    {
        $request->sat ??= $request->merge(['sat' => null]);
        $request->sun ??= $request->merge(['sun' => null]);
        try {
            AttendanceSetting::first()->update($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'mengubah jam hadir';
        return back()->with('alert', $alert);
    }

    public function qrcode()
    {
        $path = storage_path('app/public/img/qrcode.png');
        QrCode::format('png')->size(500)->generate(AttendanceSetting::first()->qrcode, $path);

        return response()->download($path);
    }

    public function updateQrcode()
    {
        try {
            AttendanceSetting::first()->update(['qrcode' => bcrypt('nqm' . time() . 'education')]);
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
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'ubah absen';
        return back()->with('alert', $alert);
    }

    public function export(Request $request)
    {
        $type = Teacher::class;

        $file = "Absensi $request->start sampai $request->end.xlsx";
        return Excel::download(new AttendanceExport($request, $type), $file);
    }
}

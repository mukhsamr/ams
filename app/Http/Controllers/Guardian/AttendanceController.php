<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\Calendar;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $subGrade = auth()->user()->guardian->subGrade;

        $filter = $request->filter ?? date('Y-m-d');
        $setting = AttendanceSetting::student();

        $holiday = Calendar::isHoliday($filter, $setting);
        $attendances = Attendance::select('attendances.*', 'users.id as user_id', 'students.nama')->withStudent($filter)->withSubGrade($subGrade->id);

        $data = [
            'filtered' => $filter,
            'holiday' => $holiday,
            'subGrade' => $subGrade,
            'attendances' => $holiday ? null : $attendances->get()
        ];
        return view('guardian.attendances.attendance', $data);
    }
}

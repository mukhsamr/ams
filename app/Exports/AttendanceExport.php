<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\Calendar;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AttendanceExport implements FromView
{
    private $start;
    private $end;
    private $type;

    public function __construct($request, $type)
    {
        $this->start = $request->start;
        $this->end = $request->end;
        $this->type = $type;
    }

    public function view(): View
    {
        $period = CarbonPeriod::create($this->start, $this->end);
        $holiday = Calendar::where('is_holiday', true)->pluck('start');

        $attendances = $this->type == 'students' ? $this->student($period, $holiday) : $this->teacher($period, $holiday);

        $results = [];
        foreach ($attendances as $name => $attendance) {
            $results[$name] = $attendance->countBy('status');
            $results[$name]['subGrade'] = $attendance->first()->subGrade;
        }
        return view('exports.' . $this->type . '.attendance', [
            'attendances' => $results
        ]);
    }

    public function student($period, $holiday)
    {
        $setting = AttendanceSetting::student();
        $weekend = [
            'Sat' => $setting->sat,
            'Sun' => $setting->sun,
        ];
        $filter = collect($period)->map(fn ($v) => ($weekend[$v->format('D')] ?? false) ? false : $v->format('Y-m-d'))->diff($holiday)->filter();

        $attendances = Attendance::select('nama', 'attendances.status')->withStudent($filter->first());
        foreach ($filter->skip(1) as $f) {
            $union = Attendance::select('nama', 'attendances.status')->withStudent($f);
            $attendances->unionAll($union);
        }

        return $attendances->orderByRaw('subGrade, nama')->get()->groupBy('nama');
    }

    public function teacher($period, $holiday)
    {
        $setting = AttendanceSetting::teacher();
        $weekend = [
            'Sat' => $setting->sat,
            'Sun' => $setting->sun,
        ];
        $filter = collect($period)->map(fn ($v) => ($weekend[$v->format('D')] ?? false) ? false : $v->format('Y-m-d'))->diff($holiday)->filter();

        $attendances = Attendance::withTeacher($filter->first())->select('nama', 'attendances.status');
        foreach ($filter->skip(1) as $f) {
            $union = Attendance::withTeacher($f)->select('nama', 'attendances.status');
            $attendances->unionAll($union);
        }

        return $attendances->orderBy('nama')->get()->groupBy('nama');
    }
}

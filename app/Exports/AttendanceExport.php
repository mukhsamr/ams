<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Calendar;
use App\Models\User;
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
        $users = User::where('userable_type', $this->type)->get();
        $period = CarbonPeriod::create($this->start, $this->end);
        $holiday = Calendar::pluck('start');
        $filter = collect($period)->map(fn ($v) => $v->isWeekend() ? false : $v->format('Y-m-d'))->diff($holiday)->filter();

        $attendances = Attendance::whereRelation('user', 'userable_type', $this->type)
            ->whereDate('date', '>=', $filter->first())
            ->whereDate('date', '<=', $filter->last())
            ->get();

        foreach ($filter as $date) {
            foreach ($users as $user) {
                if ($attendances->where('date', $date)->firstWhere('user_id', $user->id)) continue;

                $attendances->push(new Attendance([
                    'date' => $date,
                    'user_id' => $user->id,
                ]));
            }
        }

        return view('exports.attendance', [
            'attendances' => $attendances->load('user.userable:id,nama')->sortBy(fn ($q) => $q->date . $q->user->userable->nama)
        ]);
    }
}

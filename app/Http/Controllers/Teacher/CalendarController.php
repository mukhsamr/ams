<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->month) {
            $explode = explode('-', $request->month);
            $calendar = Calendar::whereYear('start', $explode[0])->whereMonth('start', $explode[1]);
        }

        $calendar ??= new Calendar;
        return view('teacher.calendars.calendar', [
            'calendars' => $calendar->paginate(15)->withQueryString(),
            'month' => $request->month
        ]);
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\Attendance as ModelsAttendance;
use App\Models\AttendanceSetting;
use App\Models\Calendar;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class Attendance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (($user = auth()->user()) && !(session()->has('isAbsen'))) {
            $type = $user->level > 1 ? 'teacher' : 'student';
            $date = date('Y-m-d');
            $setting = AttendanceSetting::$type();
            $holiday = Calendar::isHoliday($date, $setting);

            if ($holiday) {
                session($holiday);
            } else {
                $isAbsen = auth()->user()->attendances->firstWhere('date', $date);

                session([
                    'setting' => $setting,
                    'isAbsen' => boolval($isAbsen),
                ]);
            }
        }

        return $next($request);
    }
}

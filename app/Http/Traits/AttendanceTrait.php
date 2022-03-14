<?php

namespace App\Http\Traits;

use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\Calendar;
use App\Models\User;

/**
 * Check attendance
 */

trait AttendanceTrait
{
    public static function isAbsen($username)
    {
        if (session('isAbsen')) return false;

        $date = date('Y-m-d');
        $setting = AttendanceSetting::first();
        $holiday = Calendar::isHoliday($date, $setting);

        if ($holiday) {
            session($holiday);
        } else {
            $isAbsen = Attendance::where([
                'user_id' => User::firstWhere('username', $username)->id,
                'date' => $date
            ])->first();

            session([
                'setting' => $setting,
                'isAbsen' => boolval($isAbsen),
            ]);
        }
    }
}

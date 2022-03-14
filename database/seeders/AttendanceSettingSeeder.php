<?php

namespace Database\Seeders;

use App\Models\AttendanceSetting;
use Illuminate\Database\Seeder;

class AttendanceSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AttendanceSetting::insert([
            [
                'type' => 'student',
                'start' => '07:00:00',
                'end' => '08:00:00',
                'sat' => null,
                'sun' => 1,
                'qrcode' => bcrypt('student.nqm' . time() . 'education')
            ], [
                'type' => 'teacher',
                'start' => '07:00:00',
                'end' => '08:00:00',
                'sat' => null,
                'sun' => 1,
                'qrcode' => bcrypt('teacher.nqm' . time() . 'education')
            ]
        ]);
    }
}

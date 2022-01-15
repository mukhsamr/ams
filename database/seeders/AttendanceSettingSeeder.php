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
            'start' => '07:00:00',
            'end' => '08:00:00',
            'sat' => null,
            'sun' => 1,
            'qrcode' => bcrypt('nqm' . time() . 'education')
        ]);
    }
}

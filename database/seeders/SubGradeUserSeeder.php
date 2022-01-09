<?php

namespace Database\Seeders;

use App\Models\SubGrade;
use App\Models\SubGradeUser;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubGradeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('userable_type', Teacher::class)->pluck('id')->toArray();
        $subGrades = SubGrade::all()->pluck('id')->toArray();

        foreach ($users as $user) {
            $index = null;
            $rand = mt_rand(0, 5);
            for ($i = 1; $i <= mt_rand(1, 2); $i++) {
                if ($i > 1) while (in_array(($index = mt_rand(0, 5)), [$rand]));
                $index ??= $rand;
                $data[] = [
                    'user_id' => $user,
                    'sub_grade_id' => $subGrades[$index],
                ];
            }
        }

        SubGradeUser::insert($data);
    }
}

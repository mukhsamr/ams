<?php

namespace Database\Seeders;

use App\Models\SubGrade;
use Illuminate\Database\Seeder;

class SubGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sub_grades =
            [
                [
                    'sub_grade' => '7A',
                    'name'  => 'Muhammad Al Fatih',
                    'grade_id' => '1'
                ],
                [
                    'sub_grade' => '7B',
                    'name'  => 'Khadijah Binti Khuwailid',
                    'grade_id' => '1'
                ],
                [
                    'sub_grade' => '8A',
                    'name'  => 'Shalahuddin Al Ayyubi',
                    'grade_id' => '2'
                ],
                [
                    'sub_grade' => '8B',
                    'name'  => 'Aisyah Binti Abu Bakar',
                    'grade_id' => '2'
                ],
                [
                    'sub_grade' => '9A',
                    'name'  => 'Umar Bin Abdul Aziz',
                    'grade_id' => '3'
                ],
                [
                    'sub_grade' => '9B',
                    'name'  => 'Fatimah Binti Muhammad',
                    'grade_id' => '3'
                ],
            ];

        SubGrade::insert($sub_grades);
    }
}

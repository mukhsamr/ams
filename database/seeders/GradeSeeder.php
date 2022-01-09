<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grades =
            [
                [
                    'grade' => 7,
                ],
                [
                    'grade' => 8,
                ],
                [
                    'grade' => 9,
                ],
            ];

        Grade::insert($grades);
    }
}

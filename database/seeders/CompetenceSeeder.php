<?php

namespace Database\Seeders;

use App\Models\Competence;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Version;
use Illuminate\Database\Seeder;
use Faker\Factory;

class CompetenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =  Factory::create();
        $version = Version::firstWhere('is_used', 1)->id;
        $grades = Grade::pluck('id')->toArray();
        $subjects = Subject::pluck('id')->toArray();

        $data = [];
        for ($i = 0; $i < 50; $i++) {
            $data[] = [
                'competence' => mt_rand(1, 5),
                'type' => mt_rand(1, 2),
                'value' => $faker->sentence(),
                'summary' => $faker->sentence(),
                'kkm' => $faker->randomFloat(2, 60, 90),
                'grade_id' => $grades[mt_rand(0, 2)],
                'subject_id' => $subjects[mt_rand(0, (count($subjects) - 1))],
                'version_id' => $version
            ];
        }
        $collect = collect($data)->unique(fn ($v) => $v['competence'] . $v['type'] . $v['grade_id'] . $v['subject_id'] . $v['version_id']);

        Competence::insert($collect->toArray());
    }
}

<?php

namespace Database\Factories;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Version;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompetenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $version = Version::where('use', 1)->first()->id;
        $grades = Grade::all()->pluck('id')->toArray();
        $subjects = Subject::all()->pluck('id')->toArray();

        return [
            'competence' => mt_rand(1, 5),
            'type' => mt_rand(1, 2),
            'value' => $this->faker->sentence(),
            'summary' => $this->faker->sentence(),
            'english' => $this->faker->sentence(),
            'kkm' => $this->faker->randomFloat(2),
            'grade' => $grades[mt_rand(0, 2)],
            'subject_id' => $subjects[mt_rand(0, (count($subjects) - 1))],
            'version_id' => $version
        ];
    }
}

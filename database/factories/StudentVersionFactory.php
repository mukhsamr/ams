<?php

namespace Database\Factories;

use App\Models\SubGrade;
use App\Models\Version;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentVersionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $subGrade = SubGrade::pluck('id')->toArray();
        $version = Version::firstWhere('is_used', 1)->id;
        return [
            'sub_grade_id' => $subGrade[mt_rand(0, (count($subGrade) - 1))],
            'version_id' => $version,
        ];
    }
}

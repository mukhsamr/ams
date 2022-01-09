<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $data = ['L', 'P'];
        $gender = $data[mt_rand(0, 1)];
        return [
            'nama' => $this->faker->name($gender == 'L' ? 'male' : 'female'),
            'nipd' => $this->faker->unique()->nik(),
            'nisn' => $this->faker->unique()->nik(),
            'jenis_kelamin' => $gender,
        ];
    }
}

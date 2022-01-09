<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\StudentVersion;
use Faker\Factory;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $students = StudentVersion::all();

        $data = [];
        foreach ($students as $student) {
            $data[] = [
                'student_version_id' => $student->id,
                'called' => $faker->firstName(),
                'note' => $faker->sentence()
            ];
        }

        Note::insert($data);
    }
}

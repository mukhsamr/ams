<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =
            [
                [
                    'subject'   => 'PAI',
                    'english'   => 'Islamic Studies',
                    'raport'    => true,
                    'local_content' => false
                ],
                [
                    'subject'   => 'PKN',
                    'english'   => 'Civics',
                    'raport'    => true,
                    'local_content' => false
                ],
                [
                    'subject'   => 'Bahasa Indonesia',
                    'english'   => 'Bahasa',
                    'raport'    => true,
                    'local_content' => false
                ],
                [
                    'subject'   => 'Bahasa Inggris',
                    'english'   => 'English',
                    'raport'    => true,
                    'local_content' => false
                ],
                [
                    'subject'   => 'Matematika',
                    'english'   => 'Math',
                    'raport'    => true,
                    'local_content' => false
                ],
                [
                    'subject'   => 'IPA',
                    'english'   => 'Science',
                    'raport'    => true,
                    'local_content' => true
                ],
                [
                    'subject'   => 'IPS',
                    'english'   => 'Sosial Science',
                    'raport'    => true,
                    'local_content' => true
                ],
            ];
        Subject::insert($data);
    }
}

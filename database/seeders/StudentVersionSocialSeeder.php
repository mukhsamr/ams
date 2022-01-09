<?php

namespace Database\Seeders;

use App\Models\Social;
use App\Models\StudentVersion;
use App\Models\StudentVersionSocial;
use Illuminate\Database\Seeder;

class StudentVersionSocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lists = Social::pluck('id')->toArray();
        $limit = count($lists) - 1;

        $data = [];
        foreach (StudentVersion::pluck('id') as $student) {
            $rand = mt_rand(0, $limit);
            $exlude = [$rand];
            for ($i = 0; $i < mt_rand(1, 5); $i++) {
                if ($i > 0) while (in_array($index = mt_rand(0, $limit), $exlude));
                $exlude[] = $index ?? null;
                $data[] = [
                    'student_version_id' => $student,
                    'social_id' => $lists[$index ?? $rand],
                ];
            }
        }
        StudentVersionSocial::insert($data);
    }
}

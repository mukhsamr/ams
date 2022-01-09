<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\SubjectUser;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubjectUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('userable_type', Teacher::class)->pluck('id')->toArray();
        $subjects = Subject::all()->pluck('id')->toArray();

        $data = [];
        foreach ($users as $user) {
            $index = null;
            $rand = mt_rand(0, 6);
            $exclude = [$rand];
            for ($i = 1; $i <= mt_rand(1, 2); $i++) {
                if ($i > 1) while (in_array(($index = mt_rand(0, 6)), $exclude));
                $exclude[] = $index ?? null;
                $data[] = [
                    'user_id' => $user,
                    'subject_id' => $subjects[$index ?? $rand],
                ];
            }
        }

        SubjectUser::insert($data);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Guardian;
use App\Models\SubGrade;
use App\Models\User;
use App\Models\Version;
use Illuminate\Database\Seeder;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('level', 3)->get();
        $SubGrades = SubGrade::pluck('id')->toArray();
        $version = Version::firstWhere('is_used', 1)->id;

        $i = 0;
        $data = [];
        foreach ($users as $user) {
            if ($i > (count($SubGrades) - 1)) break;
            $data[] = [
                'user_id' => $user->id,
                'sub_grade_id' => $SubGrades[$i++],
                'version_id' => $version,
            ];
        }
        Guardian::insert($data);
    }
}

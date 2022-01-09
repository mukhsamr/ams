<?php

namespace Database\Seeders;

use App\Models\StudentSocial;
use App\Models\StudentVersion;
use Illuminate\Database\Seeder;

class StudentSocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentSocial::insert(
            array_map(fn ($v) => ['student_version_id' => $v], StudentVersion::pluck('id')->toArray())
        );
    }
}

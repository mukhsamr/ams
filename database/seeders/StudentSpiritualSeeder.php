<?php

namespace Database\Seeders;

use App\Models\StudentSpiritual;
use App\Models\StudentVersion;
use Illuminate\Database\Seeder;

class StudentSpiritualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentSpiritual::insert(
            array_map(fn ($v) => ['student_version_id' => $v], StudentVersion::get('id')->pluck('id')->toArray())
        );
    }
}

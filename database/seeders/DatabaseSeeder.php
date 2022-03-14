<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Core
        $this->call([
            DevSeeder::class,
            TeacherSeeder::class,
            UserSeeder::class,

            SchoolSeeder::class,
            VersionSeeder::class,
            ScoreColumnSeeder::class,
            AttendanceSettingSeeder::class,
            RaportSeeder::class,
            // GradeSeeder::class,
            // SubGradeSeeder::class,
            // SubjectSeeder::class,
            // SpiritualSeeder::class,
            // SocialSeeder::class,
            // EkskulSeeder::class,
            // PersonalitySeeder::class,
        ]);

        // // User
        // Teacher::factory(50)->hasUser()->create();
        // Student::factory(100)->hasStudentVersion()->hasUser(['level' => 1])->create();

        // // Other
        // $this->call([
        //     SubjectUserSeeder::class,
        //     SubGradeUserSeeder::class,
        //     GuardianSeeder::class,
        //     CompetenceSeeder::class,
        //     NoteSeeder::class,
        //     StudentSpiritualSeeder::class,
        //     StudentSocialSeeder::class,
        //     StudentVersionSpiritualSeeder::class,
        //     StudentVersionSocialSeeder::class,
        //     StudentVersionEkskulSeeder::class,
        //     StudentVersionPersonalitySeeder::class,
        // ]);
    }
}

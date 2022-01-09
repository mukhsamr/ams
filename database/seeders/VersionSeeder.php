<?php

namespace Database\Seeders;

use App\Models\Version;
use Illuminate\Database\Seeder;

class VersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'school_year' => '2020 - 2021',
                'semester' => 1,
                'is_used' => 1
            ],
            [
                'school_year' => '2020 - 2021',
                'semester' => 2,
                'is_used' => null
            ],
        ];
        Version::insert($data);
    }
}

<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        School::insert([
            'name' => 'Nama Sekolah',
            'logo' => 'logo.png',
            'teacher_id' => 1,
            'signature' => 'signature.png'
        ]);
    }
}

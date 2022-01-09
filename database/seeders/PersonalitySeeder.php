<?php

namespace Database\Seeders;

use App\Models\Personality;
use Illuminate\Database\Seeder;

class PersonalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lists = [
            'Kebersihan',
            'Kedisiplinan',
            'Kejujuran',
            'Kemandirian',
            'Kepemimpinan',
            'Kerajinan',
            'Kerjasama',
            'Kesopanan',
            'Ketaatan'
        ];

        Personality::insert(array_map(fn ($v) => ['list' => $v], $lists));
    }
}

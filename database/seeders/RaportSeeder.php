<?php

namespace Database\Seeders;

use App\Models\Raport;
use Illuminate\Database\Seeder;

class RaportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Raport::insert([
            [
                'type' => 'pts',
                'place' => null,
                'background' => null
            ],
            [
                'type' => 'k13',
                'place' => null,
                'background' => null
            ]
        ]);
    }
}

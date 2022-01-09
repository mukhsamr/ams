<?php

namespace Database\Seeders;

use App\Models\Ekskul;
use Illuminate\Database\Seeder;

class EkskulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lists = [
            'Basket',
            'IT',
            'English',
            'Fotografi',
            'Futsal',
            'Panahan',
            'Pramuka',
            'Renang',
            'Tahfiz'
        ];

        Ekskul::insert(array_map(fn ($v) => ['list' => $v], $lists));
    }
}

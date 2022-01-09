<?php

namespace Database\Seeders;

use App\Models\ScoreColumn;
use Illuminate\Database\Seeder;

class ScoreColumnSeeder extends Seeder
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
                'name' => 'Tugas',
                'type' => 1
            ],
            [
                'name' => 'Worksheet',
                'type' => 1
            ],
            [
                'name' => 'Praktek',
                'type' => 2
            ],
            [
                'name' => 'Projek',
                'type' => 2
            ],
            [
                'name' => 'Produk',
                'type' => 2
            ],
            [
                'name' => 'Portofolio',
                'type' => 2
            ],
        ];

        ScoreColumn::insert($data);
    }
}

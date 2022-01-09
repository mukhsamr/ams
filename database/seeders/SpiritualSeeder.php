<?php

namespace Database\Seeders;

use App\Models\Spiritual;
use Illuminate\Database\Seeder;

class SpiritualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lists = [
            'berdoa sebelum dan sesudah menjalankan sesuatu',
            'berserah diri (tawakal) kepada Allah setelah berikhtiar atau melakukan usaha',
            'menjalankan ibadah tepat waktu',
            'memberi salam pada saat awal dan akhir kegiatan',
            'bersyukur atas nikmat dan karunia Allah Subhaanahu Wataa\'ala',
            'mensyukuri kemampuan manusia dalam mengendalikan diri',
            'bersyukur ketika berhasil mengerjakan sesuatu',
        ];

        $data = [];
        foreach ($lists as $list) {
            $data[] = [
                'list' => $list
            ];
        }

        Spiritual::insert($data);
    }
}

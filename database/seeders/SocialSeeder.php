<?php

namespace Database\Seeders;

use App\Models\Social;
use Illuminate\Database\Seeder;

class SocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lists = [
            'jujur',
            'disiplin',
            'tanggung jawab',
            'santun',
            'percaya diri',
            'peduli',
            'toleransi'
        ];

        Social::insert(array_map(fn ($v) => ['list' => $v], $lists));
    }
}

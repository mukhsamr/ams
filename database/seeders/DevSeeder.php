<?php

namespace Database\Seeders;

use App\Models\Dev;
use Illuminate\Database\Seeder;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dev::insert([
            'nama' => 'dev'
        ]);
    }
}

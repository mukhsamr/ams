<?php

namespace Database\Seeders;

use App\Models\Dev;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'userable_type' => Dev::class,
                'userable_id' => 1,
                'username' => 'nqmSuperAdmin',
                'password' => bcrypt('nqm.education'),
                'level' => '0',
                'status' => 'Dev',
            ],
            [
                'userable_type' => Teacher::class,
                'userable_id' => 1,
                'username' => 'Admin',
                'password' => bcrypt('admin'),
                'level' => '5',
                'status' => 'Admin',
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // create seed for user
        DB::table('users')->insert(
            [
                [
                    'username' => 'admin',
                    'password' => bcrypt('admin'),
                    'role' => 'admin',
                ],
                [
                    'username' => 'user',
                    'password' => bcrypt('user'),
                    'role' => 'user',
                ]
            ]
        );
    }
}

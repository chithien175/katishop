<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'KaTiSoft',
            'email' => 'webdepnhatrang@gmail.com',
            'password' => bcrypt('123123'),
            'admin' => 1
        ]);
    }
}

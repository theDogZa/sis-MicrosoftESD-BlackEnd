<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            [
                'username' => 'dev',
                'first_name' => 'prasong',
                'last_name' => 'putichanchai',
                'email' => 'prasong.pu@gmail.com',
                'password' => Hash::make('dev!1234'),
                'active' => 1,
                'activated' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}

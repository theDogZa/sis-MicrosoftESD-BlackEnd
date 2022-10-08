<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UsersRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_roles')->insert([
            [
                'user_id' => 1,
                'role_id' => 1,
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'slug' => 'developer',
                'name' => 'Developer',
                'description' => 'role developer',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'admin',
                'name' => 'Admin',
                'description' => 'role admin',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'user',
                'name' => 'User',
                'description' => 'role user',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RolesPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles_permissions')->insert([
            [
                'role_id' => 1,
                'permission_id' => 1,
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 1,
                'permission_id' => 2,
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 1,
                'permission_id' => 3,
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 1,
                'permission_id' => 4,
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 1,
                'permission_id' => 5,
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 1,
                'permission_id' => 6,
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 1,
                'permission_id' => 7,
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 1,
                'permission_id' => 8,
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 1,
                'permission_id' => 9,
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 1,
                'permission_id' => 10,
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 1,
                'permission_id' => 11,
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 1,
                'permission_id' => 12,
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 1,
                'permission_id' => 13,
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 1,
                'permission_id' => 14,
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 1,
                'permission_id' => 15,
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'role_id' => 1,
                'permission_id' => 16,
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}

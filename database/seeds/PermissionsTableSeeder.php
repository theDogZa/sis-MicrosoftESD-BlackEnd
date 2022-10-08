<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'slug' => 'create.users',
                'name' => 'Create Users',
                'description' => 'Create Users',
                'group_code' => 'USER',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'read.users',
                'name' => 'View Users',
                'description' => 'View Users',
                'group_code' => 'USER',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'update.users',
                'name' => 'Update Users',
                'description' => 'Update Users',
                'group_code' => 'USER',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'permission.users',
                'name' => 'View Permissions User',
                'description' => 'View Permissions User',
                'group_code' => 'USER',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'del.users',
                'name' => 'Delete Users',
                'description' => 'Delete Users',
                'group_code' => 'USER',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'create.roles',
                'name' => 'Create Roles',
                'description' => 'Create Roles',
                'group_code' => 'ROLE',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'read.roles',
                'name' => 'View Roles',
                'description' => 'View Roles',
                'group_code' => 'ROLE',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'update.roles',
                'name' => 'Update Roles',
                'description' => 'Update Roles',
                'group_code' => 'ROLE',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'del.roles',
                'name' => 'Delete Roles',
                'description' => 'Delete Roles',
                'group_code' => 'ROLE',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'users.roles',
                'name' => '	Role Users',
                'description' => 'Role Users',
                'group_code' => 'ROLE',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'permission.roles',
                'name' => '	Roles Permissions',
                'description' => 'Roles Permissions',
                'group_code' => 'ROLE',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'create.permissions',
                'name' => 'Create Rermissions',
                'description' => 'Create Rermissions',
                'group_code' => 'ROLE',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'read.permissions',
                'name' => 'View Rermissions',
                'description' => 'View Rermissions',
                'group_code' => 'ROLE',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'update.permissions',
                'name' => 'Update Rermissions',
                'description' => 'Update Rermissions',
                'group_code' => 'ROLE',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'del.permissions',
                'name' => 'Delete Rermissions',
                'description' => 'Delete Rermissions',
                'group_code' => 'ROLE',
                'active' => 1,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'slug' => 'read.log',
                'name' => 'View Logs',
                'description' => 'View Logs',
                'group_code' => 'LOG',
                'active' => 0,
                'created_uid' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}

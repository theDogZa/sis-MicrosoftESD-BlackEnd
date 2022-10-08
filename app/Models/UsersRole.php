<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class UsersRole extends Model
{
    use Sortable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_roles';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    

    public $sortable = [ 'id','user_id','role_id','active', 'created_uid', 'updated_uid'];


    public function User()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function Role()
    {
        return $this->belongsTo(Role::class, 'role_id','id');
    }
    
}

/** 
 * CRUD Laravel
 * Master ฺBY Kepex  =>  https://github.com/kEpEx/laravel-crud-generator
 * Modify/Update BY PRASONG PUTICHANCHAI
 * 
 * Latest Update : 06/08/2020 13:55
 * Version : ver.1.00.00
 *
 * File Create : 2020-09-23 17:24:28 *
 */
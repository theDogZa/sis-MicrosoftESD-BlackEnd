<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class User extends Model
{
    use Sortable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    

    public $sortable = [ 'id','username','first_name','last_name','email','email_verified_at','password','active','activated', 'user_right','remember_token','last_login', 'created_uid','updated_uid', 'created_at', 'updated_at'];

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_uid');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_uid');
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
 * File Create : 2020-09-18 17:11:34 *
 */
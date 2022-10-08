<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Example extends Model
{
    use Sortable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'Examples';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    

    public $sortable = [ 'id','parent_id','users_id','title','body','amount','date','time','datetime','status','active', 'created_uid', 'updated_uid'];


    public function Example()
    {
        return $this->belongsTo(Example::class, 'parent_id','id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'users_id','id');
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
 * File Create : 2020-09-18 17:10:04 *
 */
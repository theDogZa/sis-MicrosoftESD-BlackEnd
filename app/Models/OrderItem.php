<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class OrderItem extends Model
{
    use Sortable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_items';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    

    public $sortable = [ 'id','order_id','inventory_id','license_key','license_at', 'created_uid', 'updated_uid'];


    public function Inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id','id');
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
 * File Create : 2022-01-05 12:25:55 *
 */
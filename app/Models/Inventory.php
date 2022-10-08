<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Inventory extends Model
{
    use Sortable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'inventory';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    

    public $sortable = [ 'id','billing_id','serial','serial_long','imei','material_no','serial_raw','active','sale_status', 'created_uid', 'updated_uid', 'po_item_no'];


    public function Billing()
    {
        return $this->belongsTo(Billing::class, 'billing_id','id');
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
 * File Create : 2021-12-29 17:54:30 *
 */
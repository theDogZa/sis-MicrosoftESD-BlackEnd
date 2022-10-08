<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Order extends Model
{
    use Sortable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    

    public $sortable = [ 'id','customer_name','email','tel','path_no','receipt_no','sale_uid','sale_at', 'created_uid', 'updated_uid'];


    public function Sale_uid()
    {
        return $this->belongsTo(User::class, 'sale_uid','id');
    }

    public function OrderItem()
    {
        return $this->hasOne(OrderItem::class, 'order_id', 'id');
    }

    // public function billings()
    // {
    //     return $this->hasOne(OrderItem::class, 'order_id', 'id')->belongsTo(inventory::class, 'order_items.inventory_id', 'id')->belongsTo(billings::class, 'inventory.billing_id', 'id');
    // }
    
}

/** 
 * CRUD Laravel
 * Master ฺBY Kepex  =>  https://github.com/kEpEx/laravel-crud-generator
 * Modify/Update BY PRASONG PUTICHANCHAI
 * 
 * Latest Update : 06/08/2020 13:55
 * Version : ver.1.00.00
 *
 * File Create : 2022-01-05 11:35:12 *
 */
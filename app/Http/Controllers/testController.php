<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Models\Order;

// use App\Services\BANK\SCB;
// use App\Services\sapService;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Inventory;

class testController extends Controller
{
  /**
   * Instantiate a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    //$this->middleware('auth');
    //$this->middleware('RolePermission');
    Cache::flush();
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header('Content-Type: text/html');

  }



  function test(){
    // $search['email'] = 'prasong';
    // //return Excel::download(new OrdersExport)->test(), 'orders.xlsx');
    // return (new OrdersExport)->forSerach($search)->download('orders.xlsx');

    $results = Order::select('orders.id');
    $results = $results->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
    ->leftJoin('inventory', 'order_items.inventory_id', '=', 'inventory.id')
    ->where('order_items.license_key', null)
    ->get();

    dd($results);

    }

  }


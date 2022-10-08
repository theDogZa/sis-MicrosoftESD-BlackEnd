<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

use App\Models\Billing;
use App\Models\Inventory;
use App\Models\Order;


class DashboardController extends Controller
{
  public function __construct()
  {

    Cache::flush();
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header('Content-Type: text/html');

  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function dashboard1()
  {

    $compact = (object) [];

    $compact->Billings = Billing::select('billing_no','id', 'material_no', 'qty', 'vendor_article')->orderBy('created_at', 'DESC')->limit(10)->get();
    $compact->Inventory = Inventory::select('serial', 'id', 'billing_id', 'sale_status', 'created_at')->orderBy('created_at', 'DESC')->limit(10)->get();
    $compact->orders = Order::select('sale_at', 'path_no','id', 'sale_uid')->orderBy('sale_at','DESC')->limit(10)->get();

    $compact->pathTopSale = Order::select('orders.path_no', DB::raw("count(order_items.id) as TOTALQTY"))
    ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
    ->orderby('TOTALQTY', 'DESC')
    ->limit(10)
    ->groupBy('path_no')
    ->get();

    $arrPathTopSale = [];
    if(count($compact->pathTopSale)){
      foreach ($compact->pathTopSale as $ats) {
        if ($ats->TOTALQTY > 0) {
          $arrPathName[] = $ats->path_no;
          $arrPathQty[] = $ats->TOTALQTY;
        }
      }

      $arrPathTopSale['n'] = $arrPathName;
      $arrPathTopSale['q'] = $arrPathQty;
    }else{
      $arrPathTopSale['n'] = [];
      $arrPathTopSale['q'] = [];
    }

    $compact->ChartPathTopSale = $arrPathTopSale;

    return view('dashboard', (array) $compact);
  }
}

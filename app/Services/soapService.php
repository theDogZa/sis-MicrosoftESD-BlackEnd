<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Inventory;
use App\Stores;
use App\ArticleTransactions;
use App\Articles;
use App\Orders;
use App\OrderItems;
use App\Http\Controllers\Controller;

// turn off WSDL caching
ini_set("soap.wsdl_cache_enabled", "0");

/**
 * Update Inventory to Database for Notes
 * 
 * Last Update 2020-05-14 09:09:09
 * By Prasong putichanchai
 * 
 * 
 * STRCUSTCODE => store_code+store_platform
 * STRSISARTICLENO => article_no
 * 
 *  @return array
 */
function ServerUpdateInv($STRCUSTCODE = "", $STRSISARTICLENO = "", $STRCUSTOMERARITCLENO = "", $QTY = "", $MINSTOCK = 0, $MAXSTOCK = 0, $STRSHOPITEMID = 0,$RESERVE1 = "", $RESERVE2 = "", $RESERVE3 = "", $RESERVE4 = "", $RESERVE5 = "")
{

    $store = Stores::select('id')
        ->where(DB::raw('concat(store_code,store_platform)'), '=', $STRCUSTCODE)->first();
    Log::info('info: soapServer.php: ServerUpdateInv : be Start ----------------- ',['STRCUSTCODE'=>$STRCUSTCODE,'store'=>$store]);
    $strReturn = $STRCUSTCODE.' NO Store On web api';
    if (@isset($store->id)) {

        $arrArticle_no = explode('//',$STRSISARTICLENO);
               
        $article_no = $arrArticle_no[0];
        if(isset($arrArticle_no[1])){
            $kit = $arrArticle_no[1];
        }

        $Inventory = Inventory::GetFirst_ByArticleNoStoreId($STRSISARTICLENO, $store->id);

        if (isset($Inventory->article_id)) {

            DB::beginTransaction();
            try {
                Log::info('info: soapServer.php: ServerUpdateInv : Start ----------------- ',['article_id'=>$Inventory->article_id,'inv_id'=>$Inventory->id]);
                $uArticle = Articles::where('isactive', 1)->where('id', $Inventory->article_id);
                $uArticle->update([
                    'stock' => $QTY,
                    'updated_at' => date("Y-m-d H:i:s"),
                ]);

                $isactive = 1;
                
                $uInventory = Inventory::where('id', $Inventory->id)
                    ->update([
                        'min_stock' => $MINSTOCK,
                        'current_stock' => $QTY,
                        'max_stock' => $MAXSTOCK,
                        'shop_item_id' => $STRCUSTOMERARITCLENO,
                        'RESERVE1' => $RESERVE1,
                        'RESERVE2' => $RESERVE2,
                        'RESERVE3' => $RESERVE3,
                        'RESERVE4' => $RESERVE4,
                        'RESERVE5' => $RESERVE5,
                        'isactive' => $isactive,
                        'updated_at' => date("Y-m-d H:i:s"),
                        'updated_uid' => 0
                    ]);

                // $uArticle = Articles::where('isactive', 1)->where('article_no', $STRSISARTICLENO);
                // if ($QTY > $Inventory->current_stock) {
                //     $newStock = $QTY - $Inventory->current_stock;
                //     $uArticle->increment('stock', (int) $newStock, ['updated_at' => date("Y-m-d H:i:s")]);
                // } else {
                //     $newStock = $Inventory->current_stock - $QTY;
                //     $uArticle->decrement('stock', (int) $newStock, ['updated_at' => date("Y-m-d H:i:s")]);
                // }

                // $uInventory = Inventory::where('id', $Inventory->id)
                //     ->update([
                //         'min_stock' => $MINSTOCK,
                //         'current_stock' => $QTY,
                //         'max_stock' => $MAXSTOCK,
                //         'shop_item_id' => $STRCUSTOMERARITCLENO,
                //         'updated_at' => date("Y-m-d H:i:s"),
                //         'updated_uid' => 0
                //     ]);

                if($RESERVE5 !='NU'){ //---Not update
                    if($RESERVE5 =='NS'){ //---Not sales 
                        $QTY = 0;
                    }

                    $Controller = new Controller;
                    $returnAPI = $Controller->c_updateStockAPI($store->id, $QTY, $STRSISARTICLENO, $STRCUSTOMERARITCLENO);

                    $ArticleTransactions = new ArticleTransactions;
                    $ArticleTransactions->article_no = $STRSISARTICLENO;
                    $ArticleTransactions->old_qty = $Inventory->current_stock;
                    $ArticleTransactions->qty = $QTY - $Inventory->current_stock;
                    $ArticleTransactions->new_qty = $QTY;
                    $ArticleTransactions->type = "NOTES_UPDATE";
                    $ArticleTransactions->order_id = 0;
                    $ArticleTransactions->store_id = $store->id;
                    $ArticleTransactions->inv_id = $Inventory->id;
                    $ArticleTransactions->created_uid = 0;
                    $ArticleTransactions->created_at = date("Y-m-d H:i:s");
                    $ArticleTransactions->save();
                }
                /** -------------------------------------------
                * $aInventory
                * update qty all store by article id
                * 
                * Last Update 2020-08-24 13:09:09
                * By Prasong putichanchai
                * 
                *  @return array
                */
                
                // if(config('api.multi_stock') == true){

                //     $aInventory = Inventory::where('id', '!=', $Inventory->id)
                //     ->where('article_id',$Inventory->article_id)
                //     ->update([
                //         'current_stock' => $QTY,
                //         'updated_at' => date("Y-m-d H:i:s"),
                //         'updated_uid' => 0
                //     ]);

                //     $invUpdates = Inventory::select('id', 'current_stock', 'store_id', 'shop_item_id', 'article_no','RESERVE5')
                //     ->where('isactive', 1)
                //     ->where('id', '!=', $Inventory->id)
                //     ->where('RESERVE5', '!=','NU') //---Not update
                //     ->where('article_id', $Inventory->article_id)
                //     ->get();

                //     foreach ($invUpdates as $invUpdate) {

                //         $auArticleTransactions = (object) array();
                //         $auArticleTransactions->article_no = $invUpdate->article_no;
                //         $auArticleTransactions->store_id = $invUpdate->store_id;
                //         $auArticleTransactions->inv_id = $invUpdate->id;
                //         $auArticleTransactions->type = 'NOTES_UPDATE';
                //         $auArticleTransactions->old_qty = $invUpdate->current_stock;
                //         $auArticleTransactions->qty = $QTY - $invUpdate->current_stock;
                //         $auArticleTransactions->new_qty = $QTY;
                //         $nuArticleTransactions = ArticleTransactions::_Add($auArticleTransactions);
                //         $shop_item_id = null;
                //         if(@isset($invUpdate->shop_item_id)){
                //             $shop_item_id = $invUpdate->shop_item_id;
                //         }

                //         $Controller = new Controller;
                //         $returnAPI = $Controller->c_updateStockAPI($invUpdate->store_id, $QTY, $invUpdate->article_no, $shop_item_id);   
                //     }
                // }

                DB::commit();
                Log::info('Successful: soapServer.php:saveUpdateInv : End -----------------', ['store_id'=>$store->id,'article_no' => $STRSISARTICLENO, 'QTY' => $QTY]);
             
                $strReturn = "S200|[Saved]";
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Exception: soapServer.php:saveUpdateInv : End -----------------' . $e->getMessage());
                $strReturn = "E409|[Error]|" . $e->getMessage();
            }
        } else { //--------------- new Article

            DB::beginTransaction();
            try {
               
                $arrArticle_no = explode('//',$STRSISARTICLENO);
               
                $article_no = $arrArticle_no[0];
                if (isset($arrArticle_no[1])) {
                    $kit = $arrArticle_no[1];
                }

                //  $sArticle = Articles::select('article_no', 'id')->where('article_no', $STRSISARTICLENO)->first();
                $sArticle = Articles::select('article_no', 'id')->where('article_no', $article_no)->first();

                if (!isset($sArticle->id)) { //---- new Article_no

                    $iArticle = new Articles;
                   // $iArticle->article_no = $STRSISARTICLENO;
                    $iArticle->article_no = $article_no;
                    $iArticle->stock = $QTY;
                    $iArticle->created_uid = 0;
                    $iArticle->created_at = date("Y-m-d H:i:s");
                    $iArticle->save();
                    $articleId = $iArticle->id;
                } else {
                    $articleId = $sArticle->id;
                }

                $iInventory = new Inventory;
                $iInventory->article_id = $articleId;
                $iInventory->article_no = $STRSISARTICLENO;
                $iInventory->store_id = $store->id;
                $iInventory->min_stock = $MINSTOCK;
                $iInventory->current_stock = $QTY;
                $iInventory->max_stock = $MAXSTOCK;
                if ($STRCUSTOMERARITCLENO) {
                    $iInventory->shop_item_id = $STRCUSTOMERARITCLENO;
                }
                if ($RESERVE1) {
                    $iInventory->RESERVE1 = $RESERVE1;
                }
                if ($RESERVE2) {
                    $iInventory->RESERVE2 = $RESERVE2;
                }
                if ($RESERVE3) {
                    $iInventory->RESERVE3 = $RESERVE3;
                }
                if ($RESERVE4) {
                    $iInventory->RESERVE4 = $RESERVE4;
                }
                if ($RESERVE5) {
                    $iInventory->RESERVE5 = $RESERVE5;
                }
                
                $iInventory->created_uid = 0;
                $iInventory->created_at = date("Y-m-d H:i:s");
                $iInventory->save();

                $Controller = new Controller;
                $returnAPI = $Controller->c_updateStockAPI($store->id, $QTY, $STRSISARTICLENO, $STRCUSTOMERARITCLENO);

                $iArticleTransactions = new ArticleTransactions;
                $iArticleTransactions->article_no = $STRSISARTICLENO;
                $iArticleTransactions->old_qty = 0;
                $iArticleTransactions->qty = $QTY;
                $iArticleTransactions->new_qty = $QTY;
                $iArticleTransactions->type = "NOTES_INSERT";
                $iArticleTransactions->order_id = 0;
                $iArticleTransactions->store_id = $store->id;
                $iArticleTransactions->inv_id = $iInventory->id;
                $iArticleTransactions->created_uid = 0;
                $iArticleTransactions->created_at = date("Y-m-d H:i:s");
                $iArticleTransactions->save();

                DB::commit();
                Log::info('Successful: soapServer.php:saveUpdateInv:insert article_no : ', ['article_no' => $STRSISARTICLENO, 'QTY' => $QTY]);
                $strReturn = "S200|[Saved]";
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Exception: soapServer.php:saveUpdateInv:insert :'."---". $e->getMessage());
                $strReturn = "E409|[Error]|" . $e->getMessage();
            }
        }
    } else { //if(@$store->id)

    }
    return $strReturn;
}

/**
 * Update Order to Database for Notes
 * 
 * Last Update 2020-08-19 17:13:09
 * By Prasong putichanchai
 * 
 *  @return array
 */
function ServerUpdateOrder($STRCUSTCODE = "", $STRCUSTORDERNO = "", $STRCUSTORDERITEMNO = "",  $STRSAPORDERNO = "", $STRSAPORDERITEMNO = "", $STRSAPINVOICENO = "", $STRSAPINVOICEITEMNO = "", $STRSISARTICLENO = "", $STRSERIALIMEI = "",$RESERVE1 = "", $RESERVE2 = "", $RESERVE3 = "", $RESERVE4 = "", $RESERVE5 = "")
{

    list($sapBillingNo, $sapInvoiceNo) = explode('|', $STRSAPINVOICENO);
    
    $description = "";

    $order = Orders::select('orders.id', 'orders.order_date')
        ->leftJoin('stores', 'orders.store_id', '=', 'stores.id')
        ->where('orders.order_no', $STRCUSTORDERNO)
        ->where(DB::raw('concat(store_code,store_platform)'), '=', $STRCUSTCODE)
        ->orderBy('orders.created_at', 'desc')
        ->first();

    if (isset($order->id)) {
        DB::beginTransaction();
        try {
            $ordersUpdate = Orders::where('id', $order->id)
                ->update([
                    'sap_billing_no' => $sapBillingNo,
                    'sap_order_no' => $STRSAPORDERNO,
                    'sap_invoice_no' => $sapInvoiceNo,
                    'RESERVE1' => $RESERVE1,
                    'RESERVE2' => $RESERVE2,
                    'RESERVE3' => $RESERVE3,
                    'RESERVE4' => $RESERVE4,
                    'RESERVE5' => $RESERVE5,
                    'updated_at' => date("Y-m-d H:i:s"),
                    'updated_uid' => 0,
                ]);
                $description = ""; 
               
            if($RESERVE1){ 
                //--------- Bonus Set  ex.
                // SKU|QTY|SKU|QTY => SKU:QTY | SKU:QTY
                // sku-00a-0778|2|sku-8687-6876|1|sku-32536-0897|2 => sku-00a-0778:2|sku-8687-6876:1|sku-32536-0897:2

                $arrDesc = explode('|',$RESERVE1);
                $count = 0;
                foreach ($arrDesc as $k => $v) {
                    $count++;
                    if ($count % 2 == 1) {
                      $description .= $v . ":";
                    } else {
                      $description .= $v . "|";
                    }
                }
             
                $description = substr($description, 0, -1);
            }

            $ordersItemUpdate = OrderItems::where('order_id', $order->id)
                ->where('article_no', $STRSISARTICLENO)
                ->update([
                    'item_detail' => $STRSERIALIMEI,
                    'description' => $description,
                    'updated_at' => date("Y-m-d H:i:s"),
                    'updated_uid' => 0,
                ]);

            DB::commit();
            Log::info('Successful: soapServer.php:saveUpdateOrder : ', ['ORDER_NO' => $STRCUSTORDERNO, 'UPDATE_DATE' => date("Y-m-d H:i:s")]);
            $strReturn = "S200|[Saved]";
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Exception: soapServer.php:saveUpdateOrder :' . $e->getMessage());
            $strReturn = "E409|[Error]|" . $e->getMessage();
        }
    } else {
        Log::error('Exception: soapServer.php:saveUpdateOrder :Customer Order No ' . $STRCUSTORDERNO . ' Not Found');
        $strReturn = "E404|[Not Found]|Customer Order No '" . $STRCUSTORDERNO . "' Not Found";
    }
    return $strReturn;
}

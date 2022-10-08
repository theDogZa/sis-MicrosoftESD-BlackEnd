<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\MicrosoftController;

use App\Models\Order;

class CronJobGetSendLicenses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:getSendLicenses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get Licenses And Send to Customer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('info: CronJobGetSendLicenses.php:handle : ------------------------- Start');
        
        try {
            DB::beginTransaction();

            $results = Order::select('orders.id');
            $results = $results->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('inventory', 'order_items.inventory_id', '=', 'inventory.id')
            ->where('order_items.license_key', null)
            ->get();

            log::info('info: CronJobGetSendLicenses.php:handle : count : ', ['response' => count($results)]);

            if(count($results)>0){

                foreach($results as $order){

                    $request = ['orderID'=>$order->id];

                    $Microsoft = new MicrosoftController();
                    $res = (object)$Microsoft->_getLicensesByOrderByCronjob($order->id);

                    Log::info('info: CronJobGetSendLicenses.php:handle :test ', ['res' => $res]);
                    if(@$res->status->code==200){

                        $logs = $res->data->logs;
                        foreach($logs as $log){

                            $arrLog = array();
                            $arrLog['type'] = @$log->type;
                            $arrLog['view'] = 'A';
                            $arrLog['action'] = @$log->action;
                            $arrLog['request'] = @$log->request;
                            $arrLog['response'] = @$log->response;

                            $this->logs->addLogSys2($request, $arrLog);

                            Log::info('info: CronJobGetSendLicenses.php:handle : ',['request'=> $request, 'response'=> $res]);

                        }
                    }else{
                        Log::error('Error: CronJobGetSendLicenses:handle1', ['request' => $request, 'response' => $res]);
                    }
                }
            }

            Log::info('info: CronJobGetSendLicenses.php:handle : ------------------------- End');
        } catch (\Exception $e) {

            Log::error('Error: CronJobGetSendLicenses:handle2', ['request' => $request, 'ErrorMessage' => $e->getMessage()]);
            
        }

    }
}

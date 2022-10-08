<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\API\SAPController;

class CronJobGetDataBillings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:getDataBillings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get data Billings in SAP';

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
        $sap = new SAPController();
        Log::info('info: CronJobGetDataBillings.php:handle : ------------------------- Start');
       // if( config('api.isSendToNote') == true){
        $sap->getDataBillings();
        Log::info('info: CronJobGetDataBillings.php:handle : ------------------------- End');
     //   }else{
     //       Log::info('info: CronJobSentOrderNotes.php:handle : isSendToNote : false');
    //    }
    }
}

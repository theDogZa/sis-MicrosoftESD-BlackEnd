<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CronJobDatabaseBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:databaseBackup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'backup database';

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
     * @return int
     */
    public function handle()
    {
        Log::info('info: CronJobDatabaseBackUp.php:handle : ------------------------- Start');
        
        $backUpPath = "f:/BackUpDB/";
        //$filename = "online_stock-" . date('Y-m-d') . ".sql";
        $DUMP_PATH = 'C:\AppServ\MySQL\bin\mysqldump.exe';

        for($a=2;$a<=12;$a++){
            $n = $a-1;
            $newFileName = $backUpPath. "sis_microsoft_esd-".$n. ".sql";
            $file = $backUpPath. "sis_microsoft_esd-".$a. ".sql";

            if(file_exists($file)){
                @rename($file, $newFileName);
                sleep(3);
            }
        }

        $filename = "sis_microsoft_esd-12.sql";

        //  $command = "".env('DUMP_PATH')." --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  > " . storage_path() . "/app/backup/" . $filename;
        // $command = "" . $DUMP_PATH . " --no-defaults --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  > " . $backUpPath . $filename;
        $command = "" . $DUMP_PATH . " --no-defaults --user=root --password=P@ssw0rdSiS9 --host=127.0.0.1 sis_microsoft_esd  > " . $backUpPath . $filename;
        $returnVar = NULL;
        $output = NULL;

        exec($command, $output, $returnVar);

        //Log::info('info: CronJobDatabaseBackUp.php:handle : ',['command', $command]);

        Log::info('info: CronJobDatabaseBackUp.php:handle : ------------------------- End');

    }
}

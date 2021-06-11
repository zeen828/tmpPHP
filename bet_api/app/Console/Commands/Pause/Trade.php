<?php

namespace App\Console\Commands\Pause;

use Illuminate\Console\Command;
use Carbon;
use SystemParameter;

class Trade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trade:pause {minutes? : Specify the number of minutes ( 1 ~ 21600 )} {--y|yes : Allow execution}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Suspend trading services and automatically activate after a specified number of minutes.';

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
        try {
            /* Input minutes */
            if (!($minutes = $this->argument('minutes'))) {
                $this->comment('Specify the number of minutes ( 1 ~ 21600 ) the service is suspended.');
                /* Ask minutes */
                $minutes = $this->ask('Please enter the number of minutes of service suspension?');
            }
            /* Check length */
            if ($minutes <= 0 || $minutes > 21600) {
                $this->question('The number of minutes entered must 1 ~ 21600 !');
                $this->error('Service suspension failed.');
                return;
            }
            /* Save */
            if ($this->option('yes') || $this->confirm('Do you want to suspend the service?')) {
                if (! SystemParameter::setValue('trade_service_start_at', Carbon::now()->addMinutes($minutes)->toDateTimeString())) {
                    $this->error('System parameter value rewriting failed!');
                    $this->error('Service suspension failed.');
                }
                $this->info('The service has been changed to a suspension period.');
            } else {
                $this->info('End operation.');
            }
        } catch (\Throwable $e) {
            $this->comment('Error Information :');
            $display = [];
            $display[] = [
                'index' => 'Type',
                'description' => get_class($e)
            ];
            $display[] = [
                'index' => 'Code',
                'description' => $e->getCode()
            ];
            $display[] = [
                'index' => 'File Path',
                'description' => $e->getFile()
            ];
            $display[] = [
                'index' => 'File Line',
                'description' => $e->getLine()
            ];
            $headers = [
                'Index',
                'Description'
            ];
            $this->table($headers, $display);
            $this->error('Something error happens, please fix them.');
        }
    }
}

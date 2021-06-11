<?php

namespace App\Console\Commands\Config\Receipt;

use Illuminate\Console\Command;
use File;

class Form extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'config:add-receipt-form {name? : The name is the form name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert receipt form basic configuration';

    /**
     * The placeholder for form generating
     *
     * @var string
     */
    public $generatePlaceholder = '//:end-form-generating:';

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
            $list = config('receipt.formdefines');

            if (! is_array($list)) {
                $this->error('Receipt form configuration insert failed.');
            } else {
                /* Input name */
                if (!($name = $this->argument('name'))) {
                    $this->comment('Form\'s name uses only characters such as ( a ~ z 0 ~ 9 _ ) .');
                    /* Ask name */
                    $name = $this->ask('What is the receipt form\'s name?');
                }
                /* Check empty */
                if (! isset($name[0])) {
                    $this->question('The entered form name cannot be empty!');
                    $this->error('Receipt form configuration insert failed.');
                    return;
                }
                /* Check format */
                if (! preg_match('/^[a-z0-9_]*$/i', $name)) {
                    $this->question('The entered form name uses only characters such as ( a ~ z 0 ~ 9 _ ) .');
                    $this->error('Receipt form `' . $name . '` configuration insert failed.');
                    return;
                }
                // Check data
                if (! isset($list[$name])) {
                    // Add the provider generating to the profile
                    $content = File::get($this->getConfigPath());

                    $append = '\'' . $name . '\' => [' . PHP_EOL;
                    $append .= '            \'status\' => true,' . PHP_EOL;
                    $append .= '            \'code\' => ' . (count($list) + 1) . ',' . PHP_EOL;
                    $append .= '            \'editors\' => [' . PHP_EOL;
                    $append .= '                // Set sourceables target type code' . PHP_EOL;
                    $append .= '            ]' . PHP_EOL;
                    $append .= '        ],' . PHP_EOL;
                    $append .= '        ' . $this->generatePlaceholder;

                    $content = str_replace($this->generatePlaceholder, $append, $content);

                    File::put($this->getConfigPath(), $content);
                } else {
                    $this->line('Receipt form \'' . $name . '\' is configured!', 'fg=red;bg=cyan');
                }

                $this->info('Receipt form configuration insert successfully.');
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

    /**
     * Get config path for generated file.
     *
     * @return string
     */
    public function getConfigPath()
    {
        return base_path('config' . DIRECTORY_SEPARATOR . 'receipt.php');
    }
}

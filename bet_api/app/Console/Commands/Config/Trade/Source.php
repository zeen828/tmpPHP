<?php

namespace App\Console\Commands\Config\Trade;

use Illuminate\Console\Command;
use Str;
use File;

class Source extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'config:add-trade-source {name : The name is the entitie trade source auth model class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert trade source basic configuration class';

    /**
     * The placeholder for source generating
     *
     * @var string
     */
    public $generatePlaceholder = '//:end-source-generating:';

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
            $list = config('trade.sourceables');

            if (! is_array($list)) {
                $this->error('Trade source configuration insert failed.');
            } else {
                /* Input name */
                $name = $this->qualifyClass($this->argument('name'));

                $name = ucwords($name, '\\/');

                $list = config('trade.sourceables', []);

                $code = $this->getSourceCode($name);
                // Check data
                if (! isset($list[$code])) {
                    // Add the provider generating to the profile
                    $content = File::get($this->getConfigPath());

                    $append = '\'' . $code . '\' => [' . PHP_EOL;
                    $append .= '            \'status\' => true,' . PHP_EOL;
                    $append .= '            \'code\' => ' . (count($list) + 1) . ',' . PHP_EOL;
                    $append .= '            \'model\' => ' . $name . '::class' . PHP_EOL;
                    $append .= '        ],' . PHP_EOL;
                    $append .= '        ' . $this->generatePlaceholder;

                    $content = str_replace($this->generatePlaceholder, $append, $content);

                    File::put($this->getConfigPath(), $content);
                } else {
                    $this->line('Trade source \'' . $code . '\' is configured!', 'fg=red;bg=cyan');
                }

                $this->line('Library trait : App\\Libraries\\Traits\\Entity\\Trade\\Auth');

                $this->info('Trade source configuration insert successfully.');
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
        return base_path('config' . DIRECTORY_SEPARATOR . 'trade.php');
    }

    /**
     * Parse the class name and format.
     *
     * @param string $name
     * @return string
     */
    protected function qualifyClass($name)
    {
        $name = ltrim($name, '\\/');

        return str_replace('/', '\\', $name);
    }

    /**
     * Get the source code.
     *
     * @return string
     */
    public function getSourceCode($name)
    {
        return Str::snake(str_replace('\\', '', Str::replaceFirst('App\\Entities\\', '', $name)));
    }
}

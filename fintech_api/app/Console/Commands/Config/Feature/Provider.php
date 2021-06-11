<?php

namespace App\Console\Commands\Config\Feature;

use Illuminate\Console\Command;
use Str;
use File;

class Provider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'config:add-feature-provider {name : The name is the feature source class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert feature provider basic configuration class';

    /**
     * The placeholder for feature generating
     *
     * @var string
     */
    public $generatePlaceholder = '//:end-generating:';

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
            /* Input name */
            $name = $this->qualifyClass($this->argument('name'));

            $name = ucwords($name, '\\/');

            $providers = config('feature.providers', []);

            $provider = $this->getFeatureCode($name);
            // Check data
            if (! isset($providers[$provider])) {
                // Add feature generating to the profile providers
                $content = File::get($this->getConfigPath());

                $append = '\'' . $this->getFeatureCode($name) . '\' => ' . $name . '::class,' . PHP_EOL;
                $append .= '        ' . $this->generatePlaceholder;

                File::put($this->getConfigPath(), str_replace($this->generatePlaceholder, $append, $content));
            } else {
                $this->line('Feature provider \'' . $provider . '\' is configured!', 'fg=red;bg=cyan');
            }
            $this->info('Feature provider configuration insert successfully.');
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
        return base_path('config' . DIRECTORY_SEPARATOR . 'feature.php');
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
     * Get the feature code.
     *
     * @return string
     */
    public function getFeatureCode($name)
    {
        return Str::replaceFirst('_feature', '', Str::snake(str_replace('\\', '', Str::replaceFirst('App\\Libraries\\Features\\', '', $name))));
    }
}

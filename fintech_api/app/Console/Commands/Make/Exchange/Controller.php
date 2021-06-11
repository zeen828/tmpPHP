<?php

namespace App\Console\Commands\Make\Exchange;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Prettus\Repository\Generators\FileAlreadyExistsException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use App\Libraries\Upgrades\ExchangeControllerGenerator;
use Str;

class Controller extends Command
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'make:exchange';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new RESTful cash flow third-party provider controller.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * The suffix of class being generated.
     *
     * @var string
     */
    protected $suffix = 'Third';

    /**
     * Execute the command.
     *
     * @see fire()
     * @return void
     */
    public function handle(){
        $this->laravel->call([$this, 'fire'], func_get_args());
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function fire()
    {
        // Append base name
        $name = $this->qualifyClass($this->argument('name'));

        $name = ucwords($name, '\\/');

        $name .= (preg_match('/.*' . $this->suffix . '$/', $name) ? '' : $this->suffix);

        $name = 'Exchange\\' . $name;

        try {
            // Generate create request for controller
            $this->call('make:request', [
                'name' => $name . 'CreateRequest'
            ]);

            // Generate update request for controller
            $this->call('make:request', [
                'name' => $name . 'UpdateRequest'
            ]);

            // Generate create response for controller
            $this->call('make:response', [
                'name' => $name . 'Create'
            ]);
            
            // Generate update response for controller
            $this->call('make:response', [
                'name' => $name . 'Update'
            ]);
            
            // Generate ExceptionCode for controller
            $this->call('make:ex-code', [
                'name' => $name
            ]);

            (new ExchangeControllerGenerator([
                'name' => $name,
                'force' => $this->option('force'),
            ]))->run();

            $this->info($this->type . ' created successfully.');
        } catch (FileAlreadyExistsException $e) {
            $this->error($this->type . ' already exists!');

            return false;
        }
        // Insert feature to the profile
        $command = [];
        $command['name'] = 'App\\Http\\Controllers\\' . $name . $this->type;
        $command['type'] = $this->getExchangeCode($name);
        $command['belong'] = 'exchange';
        $command['items'] = 'client_id,client_secret,api_url,billing_url,billing_min_amount,billing_max_amount';
        $this->call('config:add-janitor-guest', $command);
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
     * The array of command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of the class',
                null
            ],
        ];
    }

    /**
     * The array of command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            [
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Force the creation if file already exists.',
                null
            ],
        ];
    }

    /**
     * Get the business code.
     *
     * @return string
     */
    public function getExchangeCode($name)
    {
        return 'exchange_' . Str::replaceFirst('_' . strtolower($this->suffix), '', Str::snake(str_replace('\\', '', Str::replaceFirst('Exchange\\', '', $name))));
    }
}
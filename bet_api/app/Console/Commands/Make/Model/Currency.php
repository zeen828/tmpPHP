<?php

namespace App\Console\Commands\Make\Model;

use Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class Currency extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Eloquent model account Currency class';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        try {
            $name = $this->qualifyClass($this->getNameInput());

            $name = ucwords($name, '\\/');

            $path = $this->getPath($name);

            // First we will check to see if the class already exists. If it does, we don't want
            // to create the class and overwrite the user's code. So, we will bail out so the
            // code is untouched. Otherwise, we will continue generating this class' files.
            if ((! $this->hasOption('force') || ! $this->option('force')) && $this->alreadyExists($name)) {
                $this->error('Account currency already exists!');

                return false;
            }

            // Insert feature to the profile
            if (! $this->hasOption('unregister') || ! $this->option('unregister')) {
                $command = [];
                $command['name'] = $name;
                $this->call('config:add-trade-currency', $command);
            }

            // Next, we will generate the path to the location where this class' file should get
            // written. Then, we will build the class and make the proper replacements on the
            // stub files so that it gets the correctly formatted namespace and class name.
            $this->makeDirectory($path);

            $this->files->put($path, $this->buildClass($name));

            $this->info('Account currency model created successfully.');

            /* Create table */
            if (! $this->hasOption('uncreate') || ! $this->option('uncreate')) {
                $command = [];
                $command['table'] = $this->getTableName($name);
                $this->call('mg-table:create-currency', $command);
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
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return base_path('resources' . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'CurrencyModel.stub');
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        return $this->laravel['path'] . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $name) . '.php';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Entities\Account';
    }

    /**
     * Get the model table name.
     *
     * @param  string  $name
     * @return string
     */
    protected function getTableName($name)
    {
        $table = Str::replaceFirst($this->getDefaultNamespace(trim($this->rootNamespace(), '\\')).'\\', '', $name);

        $table = strtr($table, ['\\' => '']);

        $table = Str::snake($table);

        if (!Str::endsWith($table, '_accounts')) {
            $table .= (Str::endsWith($table, '_account') ? 's' : '_accounts');
        }

        return $table;
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        $body = str_replace('DummyClass', $class, $stub);

        $table = $this->getTableName($name);

        $body = str_replace('DummyTable', $table, $body);

        return $body;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            [
                'force',
                null,
                InputOption::VALUE_NONE,
                'Create the class even if the file already exists'
            ],
            [
                'unregister',
                null,
                InputOption::VALUE_NONE,
                'Unregister as a acount currency'
            ],
            [
                'uncreate',
                null,
                InputOption::VALUE_NONE,
                'Cancel creation as account currency table'
            ],
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of the class'
            ]
        ];
    }
}

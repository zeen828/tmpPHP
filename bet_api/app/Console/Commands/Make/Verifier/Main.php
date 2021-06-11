<?php

namespace App\Console\Commands\Make\Verifier;

use Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class Main extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:verifier';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Verifier class for the validator';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Verifier';

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

            $name .= (preg_match('/.*' . $this->type . '$/', $name) ? '' : $this->type);

            $path = $this->getPath($name);

            // First we will check to see if the class already exists. If it does, we don't want
            // to create the class and overwrite the user's code. So, we will bail out so the
            // code is untouched. Otherwise, we will continue generating this class' files.
            if ((! $this->hasOption('force') || ! $this->option('force')) && $this->alreadyExists($name)) {
                $this->error($this->type . ' already exists!');

                return false;
            }

            // Next, we will generate the path to the location where this class' file should get
            // written. Then, we will build the class and make the proper replacements on the
            // stub files so that it gets the correctly formatted namespace and class name.
            $this->makeDirectory($path);

            $this->files->put($path, $this->buildClass($name));
        
            // Insert feature to the profile
            if (! $this->hasOption('unregister') || ! $this->option('unregister')) {
                $command = [];
                $command['name'] = $name;
                $this->call('config:add-verifier', $command);
            }
            
            $this->line('Language file : validation.php');

            $this->info($this->type . ' created successfully.');
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
        return base_path('resources' . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'Verifier.stub');
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
        return $rootNamespace . '\Libraries\Verifiers';
    }

    /**
     * Get the verifier code.
     *
     * @return string
     */
    public function getVerifierCode($name)
    {
        return Str::snake(str_replace('\\', '', Str::replaceFirst('App\\Libraries\\Verifiers\\', '', $name)));
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

        $body = str_replace('DummyCode', $this->getVerifierCode($name), $body);

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
                'Unregister as a provider'
            ]
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

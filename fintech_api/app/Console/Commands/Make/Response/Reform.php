<?php

namespace App\Console\Commands\Make\Response;

use Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class Reform extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:response';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new response success conversion class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Response';

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
        return base_path('resources' . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'ReformResponse.stub');
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
        return $rootNamespace . '\Http\Responses';
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

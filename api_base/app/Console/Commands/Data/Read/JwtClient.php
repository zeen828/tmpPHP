<?php

namespace App\Console\Commands\Data\Read;

use Illuminate\Console\Command;
use App\Repositories\Jwt\ClientRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class JwtClient extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:client-read';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read basic information about client users';

    /**
     * Indicates whether the command should be shown in the Artisan command list.
     *
     * @var bool
     */
    protected $hidden = false;

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
     * @param ClientRepository $repository
     *
     * @return mixed
     */
    public function handle(ClientRepository $repository)
    {
        $appId = $this->ask('What is the client\'s app id?');

        try {
            $model = app($repository->model());
            /* Real id */
            $id = $model->asPrimaryId($appId);
            if (isset($id)) {
                /* Check exist */
                try {
                    $client = $repository->focusClient((int) $id);
                } catch (\Throwable $e) {
                    if ($e instanceof ModelNotFoundException) {
                        $this->question('This client service does not exist!');
                        $this->error('Client read failed.');
                        return;
                    }
                    throw $e;
                }
                /* Information */
                $this->info('Information :');

                $display = [];

                foreach ($client as $key => $val) {
                    if ($key !== 'id') {
                        $display[] = [
                            'column' => $key,
                            'value' => (is_bool($val) ? ($val ? 1 : 0) : $val)
                        ];
                    }
                }

                $headers = [
                        'Column',
                        'Value'
                    ];

                $this->table($headers, $display);

                $this->info('The read returned successfully.');
            } else {
                $this->question('The entered app id is wrong!');
                $this->error('Client read failed.');
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
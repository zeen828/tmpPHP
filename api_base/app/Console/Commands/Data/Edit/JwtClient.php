<?php

namespace App\Console\Commands\Data\Edit;

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
    protected $signature = 'data:client-edit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Edit the basic information of the client users';

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
     * @return mixed
     */
    public function handle(ClientRepository $repository)
    {
        try {
            $appId = $this->ask('What is the client\'s app id?');

            /* Read info */
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
                        $this->error('Client editing failed.');
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
                $this->error('Client editing failed.');
                return;
            }
            /* change client's status */
            if ($this->confirm('Do you want to change the client\'s status?')) {
                $status = $this->ask('Do you want a status code Enable/Disable? (1/0)');
                    
                if (preg_match('/^(enable|disable|1|0)$/i', $status)) {
                    if (preg_match('/^(enable|1)$/i', $status)) {
                        $repository->focusEnable($id);
                        $this->info('The status has been successfully changed to enabled.');
                    } else {
                        $repository->focusDisable($id);
                        $this->info('The status has been successfully changed to disabled.');
                    }
                } else {
                    $this->question('Status code error!');
                    $this->error('Client status editing failed.');
                }
            }
            /* change client's ban */
            if ($this->confirm('Do you want to change the client\'s ban number?')) {
                $this->info('Ban Number List :');

                $bans = $repository->bans();

                $display = [];

                foreach ($bans as $number => $info) {
                    if ($info['status']) {
                        $display[] = [
                            'number' => $number,
                            'description' => $info['description']
                        ];
                    }
                }

                $headers = [
                    'Ban Number',
                    'Description'
                ];

                $this->table($headers, $display);

                $ban = $this->ask('Please choose to enter the user ban number as shown in the table');
                    
                if (! isset($bans[$ban]) || ! $bans[$ban]['status']) {
                    $this->question('Ban number error!');
                    $this->error('Client ban editing failed.');
                } else {
                    $repository->focusRewriteBan($id, $ban);
                    $this->info('The ban number has been successfully changed.');
                }
            }
            /* change client's name */
            if ($this->confirm('Do you want to change the client\'s name?')) {
                $name = $this->ask('Do you want a new name like?');
                if (isset($name[0])) {
                    $repository->focusRename($id, $name);
                    $this->info('The name has been successfully changed.');
                } else {
                    $this->question('The entered name cannot be empty!');
                    $this->error('Client name editing failed.');
                }
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
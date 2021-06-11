<?php

namespace App\Console\Commands\Data\Add;

use Illuminate\Console\Command;
use App\Repositories\Jwt\ClientRepository;
use App\Exceptions\Jwt\ClientExceptionCode;

class JwtClient extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:client-add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new client service';

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
        try {
            $name = $this->ask('What is the client\'s name?');

            if (isset($name[0])) {
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
                    $this->error('Client creation failed.');
                    return;
                }
                /* Save */
                if ($this->confirm('Do you want to save the creation client service?')) {
                    /* Check create */
                    try {
                        $client = $repository->build($name, $ban);
                    } catch (\Throwable $e) {
                        if ($e instanceof ClientExceptionCode) {
                            $this->question($e->getMessage());
                            $this->error('Client creation failed.');
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

                    $this->info('Client created successfully.');
                } else {
                    $this->info('End operation.');
                }
            } else {
                $this->question('The entered name cannot be empty!');
                $this->error('Client creation failed.');
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
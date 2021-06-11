<?php

namespace App\Console\Commands\Migration\Table\Create;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Prettus\Repository\Generators\Stub;
use Str;
use Schema;

class Currency extends Command
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mg-table:create-currency {table? : The table name is used for the entitie currency model class} {--y|yes : Allow execution}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a currency account table for database';

    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Get destination path for generated migration file.
     *
     * @return string
     */
    public function getMigrationPath($table)
    {
        return base_path('database' . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . $this->getMigrationFileName($table) . '.php');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return base_path('resources' . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . 'table' . DIRECTORY_SEPARATOR . 'create' . DIRECTORY_SEPARATOR . 'CurrencyAccount.stub');
    }

    /**
     * Get the migration file name.
     *
     * @return string
     */
    public function getMigrationFileName($table)
    {
        return date('Y_m_d_His_') . snake_case($this->getClassName($table));
    }

    /**
     * Get class name.
     *
     * @return string
     */
    public function getClassName($table)
    {
        return 'Create' . studly_case($table) . 'Table';
    }

    /**
     * Get table type name.
     *
     * @return string
     */
    public function getTypeName()
    {
        return 'account currency';
    }

    /**
     * Get table comment about.
     *
     * @return string
     */
    public function getTableComment($table)
    {
        if (Str::endsWith($table, '_accounts')) {
            $table = substr($table, 0, -9);
        }
        return studly_case($table) . ' 貨幣帳戶表';
    }

    /**
     * Get column note for id.
     *
     * @return string
     */
    public function getColumnNoteForId()
    {
        return '帳戶 ID';
    }

    /**
     * Get column note for holder model.
     *
     * @return string
     */
    public function getColumnNoteForHolderModel()
    {
        return '持有人 Model';
    }

    /**
     * Get column note for holder id.
     *
     * @return string
     */
    public function getColumnNoteForHolderId()
    {
        return '持有人 ID';
    }
    
    /**
     * Get column note for amount.
     *
     * @return string
     */
    public function getColumnNoteForAmount()
    {
        return '帳戶金額';
    }

    /**
     * Get column note for safe code.
     *
     * @return string
     */
    public function getColumnNoteForSafeCode()
    {
        return '安全碼';
    }

    /**
     * Get column note for created_at.
     *
     * @return string
     */
    public function getColumnNoteForCreatedAt()
    {
        return '新增時間';
    }

    /**
     * Get column note for updated_at.
     *
     * @return string
     */
    public function getColumnNoteForUpdatedAt()
    {
        return '更新時間';
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
            if (!($table = $this->argument('table'))) {
                $this->comment('Table name uses only characters such as ( a ~ z 0 ~ 9 _ ) .');
                /* Ask name */
                $table = $this->ask('What is the database table\'s name?');
            }
            /* Check empty */
            if (! isset($table[0])) {
                $this->question('The entered table name cannot be empty!');
                $this->error('The table creation failed.');
                return;
            }
            /* Check format */
            if (! preg_match('/^[a-z0-9_]*$/i', $table)) {
                $this->question('The entered table name uses only characters such as ( a ~ z 0 ~ 9 _ ) .');
                $this->error('The `' . $table . '` table creation failed.');
                return;
            }

            /* Check table exists */
            if (Schema::hasTable($table)) {
                $this->question('The `' . $table . '` table already exist!');
                $this->error('The `' . $table . '` table creation failed.');
                return;
            }

            /* Save */
            if ($this->option('yes') || $this->confirm('Do you want to save the creation `' . $table . '` table?')) {

                /* Create migrations file */

                $stubFile = $this->getStub();

                if (! file_exists($stubFile)) {
                    $this->question('The ' . $this->getTypeName() . ' type table migrations stub file does not exist!');
                    $this->error('The `' . $table . '` table creation failed.');
                    return;
                }

                $replacements = [
                    'class' => $this->getClassName($table),
                    'table' => $table,
                    'table_comment' => $this->getTableComment($table),
                    'id_note' => $this->getColumnNoteForId(),
                    'holder_model_note' => $this->getColumnNoteForHolderModel(),
                    'holder_id_note' => $this->getColumnNoteForHolderId(),
                    'amount_note' => $this->getColumnNoteForAmount(),
                    'safe_code_note' => $this->getColumnNoteForSafeCode(),
                    'created_at_note' => $this->getColumnNoteForCreatedAt(),
                    'updated_at_note' => $this->getColumnNoteForUpdatedAt()
                ];

                $contents = Stub::create($stubFile, $replacements);
                /* Migration file path */
                $path = $this->getMigrationPath($table);

                if (! $this->files->isDirectory(dirname($path))) {
                    $this->files->makeDirectory(dirname($path), 0777, true, true);
                }
                /* Write file */
                $this->files->put($path, $contents);

                $this->info('The ' . $this->getTypeName() . ' type table migration created successfully.');
            
                /* Execute migrate */
                $this->call('migrate', []);
            } else {
                $this->info('End operation.');
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

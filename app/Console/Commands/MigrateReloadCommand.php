<?php namespace App\Console\Commands;

use Config;
use DB;
use Illuminate\Console\Command;
use Schema;

class MigrateReloadCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'migrate:reload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop All Tables Systematically.';

    /**
     * Create a new command instance.
     *
     * @return \TheMasqline\Console\MigrateReloadCommand
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
    public function fire()
    {
        $tables = DB::select('SHOW TABLES');
        $tables_in_database = "Tables_in_".Config::get('database.connections.mysql.database');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $table) {
            Schema::drop($table->$tables_in_database);
            $this->info("<info>Dropped: </info>".$table->$tables_in_database);
        }
        exec('php artisan migrate --force -vvv',$migrateOutput);
        $this->info(implode("\n", $migrateOutput));
        $this->info('Migrated');
        exec('php artisan db:seed --force -vvv',$seedOutput);
        $this->info(implode("\n", $seedOutput));
        $this->info('Seeded');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

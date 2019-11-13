<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use PDO;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:database {name : The name of the database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates database with the name of your choice';

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
        $config = Config::get('database.connections.mysql');

        $db = new PDO('mysql:host='. $config['host'] . ';port=' . $config['port'], $config['username'], $config['password']);

        $name = $this->argument('name');

        $stm = $db->prepare("CREATE SCHEMA IF NOT EXISTS `$name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $stm->execute();

        $this->info(sprintf('Database named `%s` created', $this->argument('name')));
    }
}

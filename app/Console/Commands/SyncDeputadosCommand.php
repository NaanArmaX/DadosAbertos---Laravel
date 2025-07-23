<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SyncDeputadosJob;

class SyncDeputadosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:deputados';
    protected $description = 'Dispara job de sincronização com API da Câmara';

    

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
     * @return int
     */
    public function handle()
    {
           SyncDeputadosJob::dispatch();
        $this->info('Job de sincronização disparado com sucesso.');
    }

}


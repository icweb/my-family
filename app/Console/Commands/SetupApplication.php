<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'family {--demo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets up the Laravel application';

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
        $seedDemoData = $this->option('demo');

        Artisan::call('migrate:fresh --seed');
        $this->info(Artisan::output());

        if($seedDemoData !== NULL)
        {
            Artisan::call('family:demo');
            $this->info(Artisan::output());
        }

        $this->info('The applications database has been setup');
    }
}

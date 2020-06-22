<?php

namespace AMBERSIVE\Ardor\Console\Commands;

use Illuminate\Console\Command;

use Str;
use File;

use Carbon\Carbon;

use AMBERSIVE\Ardor\Jobs\RunBundler;

class ArdorRunBundler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ardor:run-bundler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will run all your bundler classes.';

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
        RunBundler::dispatch();
    }

}

<?php

namespace App\Console\Commands;

use App\Helpers\ESuccessLetter;
use App\Models\Application;
use Illuminate\Console\Command;

class TestSuccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'success';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     */
    public function handle()
    {
        $application = Application::find(19);
        (new ESuccessLetter)->generate($application);
    }
}

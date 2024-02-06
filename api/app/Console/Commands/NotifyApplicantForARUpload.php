<?php

namespace App\Console\Commands;

use App\Helpers\Utility;
use App\Models\Application;
use Illuminate\Console\Command;

class NotifyApplicantForARUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'applicant:notify';

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
        Application::where('all_ar_uploaded', 0)
            ->where('meg2_review_stage', 1)
            ->orderBy('id')
            ->chunkById(200, function ($applications) {
                foreach ($applications as $application) {
                    Utility::notifyApplicantAndContactArUpdate($application);
                }
            });
    }
}

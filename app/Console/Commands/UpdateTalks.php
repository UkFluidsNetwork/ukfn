<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TalksController;

class UpdateTalks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'talks:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Harvest talks RSS feeds';

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
        $this->line('Updating...');

        try {
            TalksController::updateTalks();
            $this->info('Talks were successfully updated.');
        } catch (Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}

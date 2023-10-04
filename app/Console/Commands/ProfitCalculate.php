<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use app\Http\Controllers\DashboardController;

class ProfitCalculate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profit:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
        $cronjob = new DashboardController();
        $cronjob->userProfits();
    }
}

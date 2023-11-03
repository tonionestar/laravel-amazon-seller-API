<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use app\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Order;
use App\Models\Purchase;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class FetchAmazonData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amazon:fetch-data';

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
        $dashboardController = new DashboardController();
        $dashboardController->orders();
    }
}

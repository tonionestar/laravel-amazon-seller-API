<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use app\Http\Controllers\DashboardController;
use App\Models\Order;
use App\Models\UserProfit;
use App\Models\User;

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
        $currentMonthStartDate = now()->startOfMonth();
        $currentMonthEndDate = now()->endOfMonth();

        $totalPositions = User::where('role', 'Client')->sum('position');

        $totalProfitCurrentMonth = Order::whereBetween('order_date', [$currentMonthStartDate, $currentMonthEndDate])->sum('profit');

        if ($totalPositions > 0) {
            $profitPerPosition = ($totalProfitCurrentMonth * 0.7) / $totalPositions;
        } else {
            $profitPerPosition = 0;
        }

        $totalProfit = $profitPerPosition * $totalPositions;

        $userProfit = new UserProfit;
        $userProfit->updateOrCreate(
            [
                'date_range' => "{$currentMonthStartDate->format('m/d')} - {$currentMonthEndDate->format('m/d')}",
                'position' => $totalPositions,
                'profit_per_position' => $profitPerPosition,
                'total_profit' => $totalProfit,
            ]
        );

        $this->info('User profits updated successfully.');
    }
}

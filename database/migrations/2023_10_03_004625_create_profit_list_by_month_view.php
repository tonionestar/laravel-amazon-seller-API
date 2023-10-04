<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProfitListByMonthView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement($this->dropView());
    }

    private function createView(): string
    {
        return <<<SQL
            CREATE VIEW profit_list_by_month AS
            SELECT
                user_id,
                month,
                position,
                total_value_adjusted,
                ROUND((total_value_adjusted / (
                    SELECT SUM(position)
                    FROM profit_list
                    WHERE month = p.month
                    GROUP BY month
                )) * position, 2) AS per_user_profit
            FROM profit_list p
        SQL;
    }

    private function dropView(): string
    {
        return <<<SQL
            DROP VIEW IF EXISTS profit_list_by_month;
        SQL;
    }
}

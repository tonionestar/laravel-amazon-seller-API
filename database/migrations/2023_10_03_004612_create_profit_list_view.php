<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateProfitListView extends Migration
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

    /**
     * The code to be run to create the view.
     *
     * @return string
     */
    private function createView(): string
    {
        return <<<SQL
            CREATE VIEW `profit_list` AS
            SELECT 
                u.id as user_id,
                o.month,
                u.position,
                (o.total_value * 0.7) AS total_value_adjusted
            FROM 
                users u 
            JOIN 
                (
                    SELECT
                        DATE_FORMAT(order_date, '%Y-%m') AS month,
                        COUNT(*) AS count_orders,
                        SUM(profit) AS total_value 
                    FROM
                        orders 
                    GROUP BY
                        DATE_FORMAT(order_date, '%Y-%m')
                ) o
            WHERE
                u.role = 'Client';
        SQL;
    }

    /**
     * The code to be run to drop the view.
     *
     * @return string
     */
    private function dropView(): string
    {
        return <<<SQL
            DROP VIEW IF EXISTS `profit_list`;
        SQL;
    }
}

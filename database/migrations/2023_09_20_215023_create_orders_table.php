<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_status');
            $table->date('order_date');
            $table->time('order_time');
            $table->string('order_id');
            $table->string('product_name');
            $table->string('product_link');
            $table->string('product_asin');
            $table->string('sku');
            $table->integer('quantity');
            $table->float('item_price', 8, 2);
            $table->float('item_total', 8, 2);
            $table->float('amazon_fee', 8, 2);
            $table->float('shipping_fee', 8, 2)->default(0);
            $table->string('shipping_carrier');
            $table->float('warehouse_fee', 8, 2);
            $table->float('profit', 8, 2);
            $table->float('cost_per_unit', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

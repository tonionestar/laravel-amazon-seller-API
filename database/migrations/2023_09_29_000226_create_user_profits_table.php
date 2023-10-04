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
        Schema::create('user_profits', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->constrained('users');
            $table->integer('user_id');
            $table->string('date_range');
            $table->integer('position');
            $table->decimal('profit_per_position', 8, 2);
            $table->decimal('total_profit', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profits');
    }
};

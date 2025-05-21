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
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('courier_assigned_at')->nullable();
            $table->timestamp('food_picked_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('actual_delivery_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'courier_assigned_at',
                'food_picked_at',
                'cancelled_at',
                'actual_delivery_time'
            ]);
        });
    }
}; 
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
        // Add food_id to reviews table
        Schema::table('reviews', function (Blueprint $table) {
            $table->uuid('food_id')->nullable()->after('id');
            $table->foreign('food_id')->references('id')->on('foods')->onDelete('cascade');
        });

        // Create food_ratings table
        Schema::create('food_ratings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('food_id');
            $table->uuid('review_id');
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('food_id')->references('id')->on('foods')->onDelete('cascade');
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_ratings');
        
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['food_id']);
            $table->dropColumn('food_id');
        });
    }
};

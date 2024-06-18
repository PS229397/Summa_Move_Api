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
        // Add exercise_id column and foreign key to performances table
        Schema::table('performances', function (Blueprint $table) {
            $table->unsignedBigInteger('exercise_id')->nullable();
            $table->foreign('exercise_id')->references('id')->on('exercises');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key and exercise_id column from performances table
        Schema::table('performances', function (Blueprint $table) {
            $table->dropForeign(['exercise_id']);
            $table->dropColumn('exercise_id');
        });

    }
};

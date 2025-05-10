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
        Schema::create('water_qualities', function (Blueprint $table) {
            $table->id();

            $table->timestamp('date_and_time');

            $table->integer('temp');
            $table->float('ph');
            $table->float('turbidity');
            $table->integer('tds');

            $table->enum('quality', ['Very Bad', 'Bad', 'Moderate', 'Good', 'Excellent'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_qualities');
    }
};

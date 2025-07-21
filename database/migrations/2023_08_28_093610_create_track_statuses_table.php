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
        Schema::create('track_status', function (Blueprint $table) {
            $table->id();
            $table->string('plant', 50)->references('plant')->on('real_bariers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('sequence', 50)->references('sequence')->on('real_bariers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('arrival_date')->references('arrival_date')->on('real_bariers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_status');
    }
};

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
        Schema::table('real_bariers', function (Blueprint $table) {
            $table->index('plant', 'idx_plant_real_bariers');
            $table->index('sequence', 'idx_sequence_real_bariers');
        });
        Schema::table('track_status', function (Blueprint $table) {
            $table->index('plant', 'idx_plant_track_status');
            $table->index('sequence', 'idx_sequence_track_status');
            $table->index('arrival_date', 'idx_arrival_date_track_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('real_bariers', function (Blueprint $table) {
            $table->dropIndex('idx_plant_real_bariers');
            $table->dropIndex('idx_sequence_real_bariers');
        });
        Schema::table('track_status', function (Blueprint $table) {
            $table->dropIndex('idx_plant_track_status');
            $table->dropIndex('idx_sequence_track_status');
            $table->dropIndex('idx_arrival_date_track_status');
        });
    }
};

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
            $table->index('arrival_date', 'idx_arrival_date_real_bariers');
        });

        Schema::table('log_barier_gates', function (Blueprint $table) {
            $table->index('arrival_date', 'idx_arrival_date_log_barier_gates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('real_bariers', function (Blueprint $table) {
            $table->dropIndex('idx_arrival_date_real_bariers');
        });

        Schema::table('log_barier_gates', function (Blueprint $table) {
            $table->dropIndex('idx_arrival_date_log_barier_gates');
        });
    }
};

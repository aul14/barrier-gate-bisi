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
            $table->date('scaling_date_3')->nullable();
            $table->time('scaling_time_3')->nullable();
            $table->string('qty_scaling_3')->nullable();
            $table->string('status_timbang_3', 50)->nullable();
            $table->date('scaling_date_4')->nullable();
            $table->time('scaling_time_4')->nullable();
            $table->string('qty_scaling_4')->nullable();
            $table->string('status_timbang_4', 50)->nullable();
        });
        Schema::table('log_barier_gates', function (Blueprint $table) {
            $table->date('scaling_date_3')->nullable();
            $table->time('scaling_time_3')->nullable();
            $table->string('qty_scaling_3')->nullable();
            $table->string('status_timbang_3', 50)->nullable();
            $table->date('scaling_date_4')->nullable();
            $table->time('scaling_time_4')->nullable();
            $table->string('qty_scaling_4')->nullable();
            $table->string('status_timbang_4', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('real_bariers', function (Blueprint $table) {
            $table->dropColumn('scaling_date_3');
            $table->dropColumn('scaling_time_3');
            $table->dropColumn('qty_scaling_3');
            $table->dropColumn('status_timbang_3');
            $table->dropColumn('scaling_date_4');
            $table->dropColumn('scaling_time_4');
            $table->dropColumn('qty_scaling_4');
            $table->dropColumn('status_timbang_4');
        });
        Schema::table('log_barier_gates', function (Blueprint $table) {
            $table->dropColumn('scaling_date_3');
            $table->dropColumn('scaling_time_3');
            $table->dropColumn('qty_scaling_3');
            $table->dropColumn('status_timbang_3');
            $table->dropColumn('scaling_date_4');
            $table->dropColumn('scaling_time_4');
            $table->dropColumn('qty_scaling_4');
            $table->dropColumn('status_timbang_4');
        });
    }
};

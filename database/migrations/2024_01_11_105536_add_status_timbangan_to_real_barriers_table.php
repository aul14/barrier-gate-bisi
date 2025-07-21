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
            $table->string('status_timbang', 50)->nullable();
        });
        Schema::table('log_barier_gates', function (Blueprint $table) {
            $table->string('status_timbang', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('real_bariers', function (Blueprint $table) {
            $table->dropColumn('status_timbang');
        });
        Schema::table('log_barier_gates', function (Blueprint $table) {
            $table->dropColumn('status_timbang');
        });
    }
};

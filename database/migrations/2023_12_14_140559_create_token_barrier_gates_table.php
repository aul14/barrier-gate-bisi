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
        Schema::create('token_barrier_gates', function (Blueprint $table) {
            $table->id();
            $table->text('token')->nullable();
            $table->timestamps();
        });

        Schema::table('log_barier_gates', function (Blueprint $table) {
            $table->string('sales_order_no', 50)->nullable();
            $table->string('reservation_no', 50)->nullable();
            $table->string('quotation_no', 50)->nullable();
            $table->string('upto_plant', 50)->nullable();
            $table->text('body_sap')->nullable();
        });
        Schema::table('real_bariers', function (Blueprint $table) {
            $table->string('sales_order_no', 50)->nullable();
            $table->string('reservation_no', 50)->nullable();
            $table->string('quotation_no', 50)->nullable();
            $table->string('upto_plant', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token_barrier_gates');
        Schema::table('log_barier_gates', function (Blueprint $table) {
            $table->dropColumn('sales_order_no');
            $table->dropColumn('reservation_no');
            $table->dropColumn('quotation_no');
            $table->dropColumn('upto_plant');
            $table->dropColumn('body_sap');
        });
        Schema::table('real_bariers', function (Blueprint $table) {
            $table->dropColumn('sales_order_no');
            $table->dropColumn('reservation_no');
            $table->dropColumn('quotation_no');
            $table->dropColumn('upto_plant');
        });
    }
};

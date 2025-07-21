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
        Schema::create('real_bariers', function (Blueprint $table) {
            $table->id();
            $table->string('plant', 50);
            $table->string('sequence', 50);
            $table->string('truck_no', 50)->nullable();
            $table->date('arrival_date');
            $table->time('arrival_time')->nullable();
            $table->string('type_scenario', 100)->nullable();
            $table->string('truck_type', 50)->nullable();
            $table->string('vendor_do', 50)->nullable();
            $table->string('jenis_kendaraan', 50)->nullable();
            $table->string('status', 100)->nullable();
            $table->string('next_status', 100)->nullable();
            $table->date('scaling_date_1')->nullable();
            $table->time('scaling_time_1')->nullable();
            $table->string('qty_scaling_1')->nullable();
            $table->date('scaling_date_2')->nullable();
            $table->time('scaling_time_2')->nullable();
            $table->string('qty_scaling_2')->nullable();
            $table->string('ship_to_party')->nullable();
            $table->text('delivery_order_no')->nullable();
            $table->string('material', 100)->nullable();
            $table->string('from_storage_location', 100)->nullable();
            $table->string('upto_storage_location', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_bariers');
    }
};

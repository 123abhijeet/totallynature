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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id('vehicle_id');
            $table->string('vehicle_modal')->nullable();
            $table->string('license_plate');
            $table->string('current_odometer')->nullable();
            $table->string('last_odometer')->nullable();
            $table->string('next_servicing_odometer')->nullable();
            $table->string('model_year')->nullable();
            $table->string('model_color')->nullable();
            $table->string('horsepower')->nullable();
            $table->string('fuel_type')->nullable();
            $table->integer('servicing_status')->nullable();
            $table->integer('created_by');
            $table->integer('company_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};

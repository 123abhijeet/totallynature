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
        Schema::create('services', function (Blueprint $table) {
            $table->id('service_id');
            $table->integer('driver_id');
            $table->integer('vehicle_id');
            $table->longText('description')->nullable();
            $table->string('service_type')->nullable();
            $table->string('date')->nullable();
            $table->string('odometer_value')->nullable();
            $table->string('cost')->nullable();
            $table->longText('notes')->nullable();
            $table->string('invoice_file')->nullable();
            $table->string('odometer_file')->nullable();
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
        Schema::dropIfExists('services');
    }
};

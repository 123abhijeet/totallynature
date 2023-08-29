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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id('driver_id');
            $table->string('username');
            $table->string('driver_name');
            $table->string('region')->nullable();
            $table->string('postal_code');
            $table->string('address');
            $table->string('unit_code')->nullable();
            $table->string('dob');
            $table->string('password');
            $table->string('mobile_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->integer('vehicle_id')->nullable();
            $table->string('license_plate')->nullable();
            $table->string('driver_file')->nullable();
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
        Schema::dropIfExists('drivers');
    }
};

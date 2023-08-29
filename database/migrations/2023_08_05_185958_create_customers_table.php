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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customer_id');
            $table->string('customer_type');
            $table->string('customer_unique_id');
            $table->longText('customer_image')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('whatsapp_no')->nullable();
            $table->string('email_id')->nullable();
            $table->string('postal_code');
            $table->string('address');
            $table->string('unit_number');
            $table->integer('region');
            $table->integer('payment_terms');
            $table->integer('payment_type');
            $table->string('credit_limit')->nullable();
            $table->string('company_name')->nullable();
            $table->string('office_no')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_person_no')->nullable();
            $table->string('website')->nullable();
            $table->integer('price_structure');
            $table->integer('company_id')->nullable();
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

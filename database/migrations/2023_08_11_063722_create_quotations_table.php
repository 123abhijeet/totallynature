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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id('quotation_id');
            $table->string('quotation_number');
            $table->integer('customer_id');
            $table->string('invoice_address');
            $table->string('delivery_address')->nullable();
            $table->string('order_date');
            $table->string('due_date')->nullable();
            $table->string('tax')->nullable();
            $table->integer('tax_inclusive');
            $table->integer('payment_type');
            $table->integer('payment_terms');
            $table->string('sales_person');
            $table->string('remark')->nullable();
            $table->string('untaxted_amount');
            $table->string('taxes')->nullable();
            $table->integer('price_structure');
            $table->string('net_total');
            $table->integer('status')->default('1');
            $table->string('tandc')->nullable();
            $table->integer('convert_so')->default('0')->nullable();
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
        Schema::dropIfExists('quotations');
    }
};

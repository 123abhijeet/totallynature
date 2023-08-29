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
        Schema::create('quotationproducts', function (Blueprint $table) {
            $table->id('quotation_product_id');
            $table->integer('quotation_id');
            $table->string('quotation_number');
            $table->integer('product_id');
            $table->string('product_unique_id');
            $table->string('description')->nullable();
            $table->string('uom')->nullable();
            $table->integer('quantity');
            $table->string('category');
            $table->string('variant');
            $table->string('unit_price');
            $table->string('amount');
            $table->integer('convert_so')->default('0');
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
        Schema::dropIfExists('quotationproducts');
    }
};

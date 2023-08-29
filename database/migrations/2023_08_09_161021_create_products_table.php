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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_image')->nullable();
            $table->string('product_name');
            $table->string('product_unique_id');
            $table->string('for_sale')->nullable();
            $table->string('for_internal_use')->nullable();
            $table->string('foc_sample')->nullable();
            $table->integer('product_type_id');
            $table->string('internal_reference')->nullable();
            $table->integer('category_id');
            $table->longText('product_description')->nullable();
            $table->integer('uom_category_id');
            $table->integer('uom_measure_id');
            $table->integer('warehouse_id');
            $table->integer('warehouse_sub_location_id');
            $table->integer('safety_stock');
            $table->integer('notification_for_expiry');
            $table->string('hs_code')->nullable();
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

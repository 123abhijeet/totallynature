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
        Schema::create('vehicledocuments', function (Blueprint $table) {
            $table->id('vehicle_document_id');
            $table->integer('vehicle_id');
            $table->string('document_title');
            $table->string('document_issue_date')->nullable();
            $table->string('document_expiry_date')->nullable();
            $table->string('document_file')->nullable();
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
        Schema::dropIfExists('vehicledocuments');
    }
};

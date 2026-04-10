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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string("invoie")->unique();
            $table->foreignId("customer_id")->constrained('customers');
            $table->foreignId("cabang_id")->constrained('cabangs');
            $table->integer("total");
            $table->enum('progress', ['diterima','selesai','komplit']);
            $table->integer('deadline');
            $table->boolean('spesial_treatment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};

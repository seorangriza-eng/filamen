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
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan');
            $table->integer('nominal');
            $table->date('trx_date');
            $table->foreignId('cabang_id')->constrained('cabangs');
            $table->foreignId('user_id')->constrained('users');
            $table->string('ref');
            $table->string('ref_type');
            $table->foreignId('ref_id')->constrained('transaksis')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnals');
    }
};

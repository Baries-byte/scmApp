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
        Schema::create('persediaan_barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('varian_barang_id');
            $table->integer('persediaan_min');
            $table->integer('persediaan_max');
            $table->integer('pembelian_optimal')->nullable();
            $table->integer('jumlah')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persediaan_barang');
    }
};

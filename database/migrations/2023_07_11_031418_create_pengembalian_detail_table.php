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
        Schema::create('pengembalian_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengembalian_id')->constrained('pengembalian')->restrictOnDelete();
            $table->foreignId('barang_supplier_id')->constrained('barang_supplier')->restrictOnDelete();
            $table->integer('jumlah_item');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian_detail');
    }
};

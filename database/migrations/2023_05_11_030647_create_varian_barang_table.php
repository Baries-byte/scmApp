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
        Schema::create('varian_barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_master_id')->constrained('kategori')->restrictOnDelete();
            $table->string('nama_varian_barang');
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->string('kode_barang')->nullable();
            $table->string('kode_produk')->nullable();
            $table->foreignId('satuan_id')->constrained('kategori')->restrictOnDelete();
            $table->foreignId('kategori_id')->constrained('kategori')->restrictOnDelete();
            $table->text('deskripsi');
            $table->string('foto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('varian_barang');
    }
};

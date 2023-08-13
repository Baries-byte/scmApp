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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->string('nama_pelanggan');
            $table->string('alamat_pelanggan');
            $table->string('telepon_pelanggan', 15);
            $table->integer('total_item');
            $table->integer('total_harga');
            $table->integer('diskon');
            $table->string('supir', 20)->nullable();
            $table->string('kode_penjualan', 20)->nullable();
            $table->string('status_transaksi', 50)->default('Aktif');
            $table->string('status_pembayaran')->default('Belum dibayar');
            $table->string('bukti_pembayaran')->nullable();
            $table->tinyInteger('metode_pembayaran')->nullable();
            $table->tinyInteger('metode_pengiriman')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};

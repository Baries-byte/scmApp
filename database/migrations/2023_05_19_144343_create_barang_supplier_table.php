<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations
     */
    public function up(): void
    {
        Schema::create('barang_supplier', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('kode_barang', 50);
            $table->string('merek');
            $table->integer('harga_jual');
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->foreignId('supplier_id')->constrained('supplier')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_supplier');
    }
};

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
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('supplier')->restrictOnDelete();
            $table->integer('total_item');
            $table->integer('total_harga');
            $table->string('kode_purchase_order', 50)->nullable();
            $table->string('kode_purchase_order_supplier', 50)->nullable();
            $table->string('status', 50);
            $table->string('foto_surat_jalan')->nullable();
            $table->string('foto_bukti_penerimaan')->nullable();
            $table->string('foto_invoice_pembelian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order');
    }
};

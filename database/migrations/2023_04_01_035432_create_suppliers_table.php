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
        Schema::create('supplier', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan', 50);
            $table->string('alamat', 100);
            $table->string('telepon');
            $table->string('email', 50);
            $table->string('kode_supplier', 5)->nullable();
            $table->tinyInteger('kerja_sama')->default(1);
            $table->foreignId('user_id')->default(1)->constrained()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier');
    }
};

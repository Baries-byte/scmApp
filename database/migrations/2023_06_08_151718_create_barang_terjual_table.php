<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_terjual', function (Blueprint $table) {
            $table->id();
            $table->foreignId('varian_barang_id');
            $table->integer('jumlah');
            $table->timestamps();
        });

        DB::unprepared('
        CREATE TRIGGER barang_terjual_trigger AFTER INSERT ON barang_terjual
        FOR EACH ROW
        BEGIN
            UPDATE persediaan_barang SET jumlah = jumlah - NEW.jumlah WHERE varian_barang_id = NEW.varian_barang_id;
        END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_terjual');
        DB::unprepared('DROP TRIGGER IF EXISTS barang_terjual_trigger');
    }
};

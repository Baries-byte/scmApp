<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_dibeli', function (Blueprint $table) {
            $table->id();
            $table->foreignId('varian_barang_id');
            $table->integer('jumlah');
            $table->timestamps();
        });

        DB::unprepared('
            CREATE TRIGGER barang_dibeli_trigger AFTER INSERT ON
            barang_dibeli
            FOR EACH ROW
            BEGIN
                UPDATE persediaan_barang SET jumlah = jumlah + NEW.jumlah WHERE varian_barang_id = NEW.varian_barang_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_dibeli');
        DB::unprepared('DROP TRIGGER IF EXISTS barang_dibeli_trigger');
    }
};

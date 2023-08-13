<?php

namespace Database\Seeders;

use App\Models\BarangTerjual;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangTerjual6BulanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Data barang terjual 6 bulan

        // Data Bulan ke 6
        BarangTerjual::create([
            'varian_barang_id' => 3,
            'jumlah' => 1020,
            'created_at' => '2023-06-06 13:13:13',
            'updated_at' => '2023-06-06 13:13:13'
        ]);

        //Data bulan ke 7
        BarangTerjual::create([
            'varian_barang_id' => 3,
            'jumlah' => 1230,
            'created_at' => '2023-07-06 13:13:13',
            'updated_at' => '2023-07-06 13:13:13'
        ]);

        //Data bulan ke 8
        BarangTerjual::create([
            'varian_barang_id' => 3,
            'jumlah' => 1032,
            'created_at' => '2023-08-06 13:13:13',
            'updated_at' => '2023-08-06 13:13:13'
        ]);

        // //Data bulan ke 9
        // BarangTerjual::create([
        //     'barang_id' => 1,
        //     'jumlah' => 18,
        //     'created_at' => '2023-09-06 13:13:13',
        //     'updated_at' => '2023-09-06 13:13:13'
        // ]);
        // BarangTerjual::create([
        //     'barang_id' => 1,
        //     'jumlah' => 20,
        //     'created_at' => '2023-09-07 13:13:13',
        //     'updated_at' => '2023-09-07 13:13:13'
        // ]);
        // BarangTerjual::create([
        //     'barang_id' => 1,
        //     'jumlah' => 11,
        //     'created_at' => '2023-09-08 13:13:13',
        //     'updated_at' => '2023-09-08 13:13:13'
        // ]);

        // //Data bulan ke 10
        // BarangTerjual::create([
        //     'barang_id' => 1,
        //     'jumlah' => 11,
        //     'created_at' => '2023-10-06 13:13:13',
        //     'updated_at' => '2023-10-06 13:13:13'
        // ]);
        // BarangTerjual::create([
        //     'barang_id' => 1,
        //     'jumlah' => 9,
        //     'created_at' => '2023-10-07 13:13:13',
        //     'updated_at' => '2023-10-07 13:13:13'
        // ]);
        // BarangTerjual::create([
        //     'barang_id' => 1,
        //     'jumlah' => 7,
        //     'created_at' => '2023-10-08 13:13:13',
        //     'updated_at' => '2023-10-08 13:13:13'
        // ]);

        // //Data bulan ke 11
        // BarangTerjual::create([
        //     'barang_id' => 1,
        //     'jumlah' => 11,
        //     'created_at' => '2023-11-06 13:13:13',
        //     'updated_at' => '2023-11-06 13:13:13'
        // ]);
        // BarangTerjual::create([
        //     'barang_id' => 1,
        //     'jumlah' => 13,
        //     'created_at' => '2023-11-07 13:13:13',
        //     'updated_at' => '2023-11-07 13:13:13'
        // ]);
        // BarangTerjual::create([
        //     'barang_id' => 1,
        //     'jumlah' => 10,
        //     'created_at' => '2023-11-08 13:13:13',
        //     'updated_at' => '2023-11-08 13:13:13'
        // ]);
    }
}

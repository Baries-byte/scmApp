<?php

namespace Database\Seeders;

use App\Models\BarangTerjual;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BarangTerjual12BulanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Data barang terjual 12 bulan

        //Data bulan ke 9
        BarangTerjual::create([
            'varian_barang_id' => 3,
            'jumlah' => 1098,
            'created_at' => '2023-09-06 13:13:13',
            'updated_at' => '2023-09-06 13:13:13'
        ]);

        //Data bulan ke 10
        BarangTerjual::create([
            'varian_barang_id' => 3,
            'jumlah' => 1012,
            'created_at' => '2023-10-06 13:13:13',
            'updated_at' => '2023-10-06 13:13:13'
        ]);

        //Data bulan ke 11
        BarangTerjual::create([
            'varian_barang_id' => 3,
            'jumlah' => 1008,
            'created_at' => '2023-11-06 13:13:13',
            'updated_at' => '2023-11-06 13:13:13'
        ]);

        //Data bulan ke 12
        BarangTerjual::create([
            'varian_barang_id' => 3,
            'jumlah' => 1042,
            'created_at' => '2023-12-06 13:13:13',
            'updated_at' => '2023-12-06 13:13:13'
        ]);

        //Data bulan ke 1
        BarangTerjual::create([
            'varian_barang_id' => 3,
            'jumlah' => 1051,
            'created_at' => '2024-01-06 13:13:13',
            'updated_at' => '2024-01-06 13:13:13'
        ]);

        //Data bulan ke 2
        BarangTerjual::create([
            'varian_barang_id' => 3,
            'jumlah' => 1084,
            'created_at' => '2024-02-06 13:13:13',
            'updated_at' => '2024-02-06 13:13:13'
        ]);

        //Data bulan ke 3
        BarangTerjual::create([
            'varian_barang_id' => 3,
            'jumlah' => 1075,
            'created_at' => '2024-03-06 13:13:13',
            'updated_at' => '2024-03-06 13:13:13'
        ]);

        //Data bulan ke 4
        BarangTerjual::create([
            'varian_barang_id' => 3,
            'jumlah' => 1052,
            'created_at' => '2024-04-06 13:13:13',
            'updated_at' => '2024-04-06 13:13:13'
        ]);

        //Data bulan ke 5
        BarangTerjual::create([
            'varian_barang_id' => 3,
            'jumlah' => 1061,
            'created_at' => '2024-05-06 13:13:13',
            'updated_at' => '2024-05-06 13:13:13'
        ]);
    }
}

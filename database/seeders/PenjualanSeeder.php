<?php

namespace Database\Seeders;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Penjualan::create([
            'user_id' => 1,
            'nama_pelanggan' => 'Ilham',
            'alamat_pelanggan' => 'Jalan Asia-Afrika',
            'telepon_pelanggan' => '081248208572',
            'total_item' => 15,
            'total_harga' => 810000,
            'diskon' => 0,
            'metode_pembayaran' => 0,
            'status_transaksi' => 'Diproses'
        ]);
        Penjualan::create([
            'user_id' => 1,
            'nama_pelanggan' => 'Rama',
            'alamat_pelanggan' => 'Jalan Kalimantan',
            'telepon_pelanggan' => '081275915917',
            'total_item' => 20,
            'total_harga' => 132000,
            'diskon' => 0,
            'metode_pembayaran' => 0,
            'status_transaksi' => 'Dikirim'
        ]);

        Penjualan::create([
            'user_id' => 1,
            'nama_pelanggan' => 'Rama',
            'alamat_pelanggan' => 'Jalan Kalimantan',
            'telepon_pelanggan' => '081275915917',
            'total_item' => 20,
            'total_harga' => 132000,
            'diskon' => 0,
            'metode_pembayaran' => 0,
            'status_transaksi' => 'Selesai'
        ]);

        DetailPenjualan::create(
            [
            'penjualan_id' => 1,
            'barang_id' => 1,
            'jumlah_item' => 5,
            'sub_total' => 600000
            ],
        );
        DetailPenjualan::create(
            [
            'penjualan_id' => 1,
            'barang_id' => 3,
            'jumlah_item' => 10,
            'sub_total' => 12000
            ],
        );

        DetailPenjualan::create(
            [
            'penjualan_id' => 2,
            'barang_id' => 5,
            'jumlah_item' => 2,
            'sub_total' => 190000
            ],
        );
        DetailPenjualan::create(
            [
            'penjualan_id' => 2,
            'barang_id' => 4,
            'jumlah_item' => 1,
            'sub_total' => 12000
            ],
        );
    }
}

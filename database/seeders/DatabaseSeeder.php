<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Pelanggan;
use App\Models\BarangMaster;
use App\Models\VarianBarang;
use App\Models\BarangSupplier;
use Illuminate\Database\Seeder;
use App\Models\PersediaanBarang;
use App\Models\Satuan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // DATA USER
        // Pemilik (Super Admin)
        User::create([
            'nama' => 'Pemilik',
            'email' => 'pemilik123@gmail.com',
            'alamat' => 'Jakarta',
            'password' => bcrypt('pemilik123'),
            'telepon' => '0812592523',
            'level' => 1
        ]);
        // Pegawai Admin
        User::create([
            'nama' => 'Admin',
            'email' => 'admin123@gmail.com',
            'alamat' => 'Jakarta',
            'password' => bcrypt('admin123'),
            'telepon' => '0812592523',
            'level' => 2
        ]);
        // Supplier
        User::create([
            'nama' => 'Dina',
            'email' => 'dina123@gmail.com',
            'alamat' => 'Jakarta',
            'password' => bcrypt('dina123'),
            'telepon' => '0812595629',
            'level' => 3
        ]);
        User::create([
            'nama' => 'Adji',
            'email' => 'adji123@gmail.com',
            'alamat' => 'Tanggerang',
            'password' => bcrypt('adji123'),
            'telepon' => '0812592512',
            'level' => 3
        ]);
        User::create([
            'nama' => 'Budi',
            'email' => 'budi123@gmail.com',
            'alamat' => 'Bandung',
            'password' => bcrypt('budi123'),
            'telepon' => '0812592631',
            'level' => 3
        ]);
        // Pembeli
        User::create([
            'nama' => 'Dian',
            'email' => 'dian123@gmail.com',
            'alamat' => 'Jakarta',
            'password' => bcrypt('dian123'),
            'telepon' => '0812595629',
            'level' => 0
        ]);



        // DATA PELANGGAN
        Pelanggan::create([
            'nama' => 'Ilham',
            'alamat' => 'Jalan Asia-Afrika',
            'telepon' => '081248208572'
        ]);
        Pelanggan::create([
            'nama' => 'Rama',
            'alamat' => 'Jalan Kalimantan',
            'telepon' => '081275915917'
        ]);

        

        // DATA SUPPLIER
        Supplier::create([
            'nama_perusahaan' => 'Tiga Roda',
            'kode_supplier' => 'TIROD',
            'alamat' => 'Jakarta',
            'telepon' => '082477120242',
            'email' => 'tigaroda@gmail.com',
            'user_id' => 3
        ]);
        Supplier::create([
            'nama_perusahaan' => 'Sherlock Secure',
            'kode_supplier' => 'SHSEC',
            'alamat' => 'Bandung',
            'telepon' => '082471426341',
            'email' => 'sherlocksecure@gmail.com',
            'user_id' => 4
        ]);
        Supplier::create([
            'nama_perusahaan' => 'Krakatau Steel',
            'kode_supplier' => 'KRSTE',
            'alamat' => 'Banten',
            'telepon' => '082471202042',
            'email' => 'krakatausteel@gmail.com',
            'user_id' => 5
        ]);
        


        // DATA KATEGORI
        Kategori::create([
            'kategori' => 'Semen'
        ]);
        Kategori::create([
            'kategori' => 'Gembok'
        ]);
        Kategori::create([
            'kategori' => 'Besi'
        ]);
        Kategori::create([
            'kategori' => 'Paku'
        ]);

        // Data Satuan
        Satuan::create([
            'satuan' => 'Sak'
        ]);


        BarangMaster::create([
            'nama_barang' => 'Tiga Roda',
            'merek' => 'Tiga Roda',
            'supplier_id' => 1,
            'kategori_id' => 1,
        ]);

        BarangMaster::create([
            'nama_barang' => 'Gembok Sherlock',
            'merek' => 'Gembok Sherlock',
            'supplier_id' => 2,
            'kategori_id' => 2,
        ]);

        VarianBarang::create([
            'barang_master_id' => 1,
            'nama_varian_barang' => 'Tiga Roda',
            'harga_beli' => 20000,
            'harga_jual' => 25000,
            'kode_barang' => '00000',
            'kode_produk' => '00000',
            'satuan_id' => 1,
            'kategori_id' => 1,
            'deskripsi' => 'Semen tiga roda berat 40kg',
            'foto' => 'foto_barang_toko/gemboksherlock.jpg'
        ]);
        
        PersediaanBarang::create([
            'varian_barang_id' => 1,
            'persediaan_min' => 0,
            'persediaan_max' => 0,
            'pembelian_optimal' => 0,
            'jumlah' => 0,
        ]);

        // // DATA BARANG TOKO
        // Barang::create([
        //     'nama_barang' => 'Nippon Paint Merah 5L',
        //     'merek' => 'Nippon Paint',
        //     'harga_beli' => 100000,
        //     'harga_jual' => 120000,
        //     'supplier_id' => 1,
        //     'kategori_id' => 1,
        //     'kode_barang' => 'NIPAI010001',
        //     'foto' => 'foto_barang_toko/catnippon.jpg',
        //     'satuan' => 'Kaleng',
        //     'deskripsi' => 'Warna Merah Ukuran 5L'
        // ]);
        // Barang::create([
        //     'nama_barang' => 'Nippon Paint Hijau 5L',
        //     'merek' => 'Nippon Paint',
        //     'harga_beli' => 100000,
        //     'harga_jual' => 120000,
        //     'supplier_id' => 1,
        //     'kategori_id' => 1,
        //     'kode_barang' => 'NIPAI010002',
        //     'foto' => 'foto_barang_toko/catnippon.jpg',
        //     'satuan' => 'Kaleng',
        //     'deskripsi' => 'Warna Hijau Ukuran 5L'
        // ]);
        // Barang::create([
        //     'nama_barang' => 'Semen Tiga Roda 5kg',
        //     'merek' => 'Tiga Roda',
        //     'harga_beli' => 47000,
        //     'harga_jual' => 55000,
        //     'supplier_id' => 2,
        //     'kategori_id' => 3,
        //     'kode_barang' => 'SHSEC030003',
        //     'foto' => 'foto_barang_toko/sementigaroda.jpeg',
        //     'satuan' => 'karung',
        //     'deskripsi' => 'Semen Tiga Roda ukuran 3kg, satuan per karung'
        // ]);
        // Barang::create([
        //     'nama_barang' => 'Paku 10cm',
        //     'merek' => 'Paku',
        //     'harga_beli' => 10000,
        //     'harga_jual' => 12000,
        //     'supplier_id' => 2,
        //     'kategori_id' => 4,
        //     'kode_barang' => 'SHSEC010004',
        //     'foto' => 'foto_barang_toko/paku.jpg',
        //     'satuan' => 'kg',
        //     'deskripsi' => 'Paku ukuran 10cm'
        // ]);
        // Barang::create([
        //     'nama_barang' => 'Gembok Sherlock 60mm',
        //     'merek' => 'Sherlock',
        //     'harga_beli' => 87000,
        //     'harga_jual' => 95000,
        //     'supplier_id' => 3,
        //     'kategori_id' => 2,
        //     'kode_barang' => 'KRSTE020005',
        //     'foto' => 'foto_barang_toko/gemboksherlock.jpg',
        //     'satuan' => 'pcs',
        //     'deskripsi' => 'Gembok sherlock 60mm anti-cut'
        // ]);

        // //DATA PERSEDIAAN BARANG 
        // PersediaanBarang::create([
        //     'barang_id' => 1,
        //     'persediaan_max' => 35,
        //     'persediaan_min' => 25,
        //     'jumlah' => 20
        // ]);
        // PersediaanBarang::create([
        //     'barang_id' => 2,
        //     'persediaan_max' => 45,
        //     'persediaan_min' => 25,
        //     'jumlah' => 20
        // ]);
        // PersediaanBarang::create([
        //     'barang_id' => 3,
        //     'persediaan_max' => 50,
        //     'persediaan_min' => 30,
        //     'jumlah' => 37
        // ]);
        // PersediaanBarang::create([
        //     'barang_id' => 4,
        //     'persediaan_max' => 40,
        //     'persediaan_min' => 20,
        //     'jumlah' => 7
        // ]);
        // PersediaanBarang::create([
        //     'barang_id' => 5,
        //     'persediaan_max' => 50,
        //     'persediaan_min' => 25,
        //     'jumlah' => 5
        // ]);


        // DATA BARANG SUPPLIER
        BarangSupplier::create([
            'supplier_id' => 1,
            'nama_barang' => 'Nippon Paint Merah 5L',
            'kode_barang' => 'NP042',
            'merek' => 'Nippon Paint',
            'harga_jual' => 100000,
            'deskripsi' => 'Nippon Paint ukuran 5L',
            'foto' => 'foto_barang_supplier/catnippon.jpg'
        ]);
        BarangSupplier::create([
            'supplier_id' => 1,
            'nama_barang' => 'Nippon Paint Hijau 5L',
            'kode_barang' => 'NP020',
            'merek' => 'Nippon Paint',
            'harga_jual' => 100000,
            'deskripsi' => 'Nippon Paint ukuran 5L',
            'foto' => 'foto_barang_supplier/catnippon.jpg'
        ]);
        BarangSupplier::create([
            'supplier_id' => 1,
            'nama_barang' => 'Nippon Paint Biru 5L',
            'kode_barang' => 'NP013',
            'merek' => 'Nippon Paint',
            'harga_jual' => 100000,
            'deskripsi' => 'Nippon Paint ukuran 5L',
            'foto' => 'foto_barang_supplier/catnippon.jpg'
        ]);
        BarangSupplier::create([
            'supplier_id' => 1,
            'nama_barang' => 'Nippon Paint Kuning 5L',
            'kode_barang' => 'NP049',
            'merek' => 'Nippon Paint',
            'harga_jual' => 100000,
            'deskripsi' => 'Nippon Paint ukuran 5L',
            'foto' => 'foto_barang_supplier/catnippon.jpg'
        ]);
        BarangSupplier::create([
            'supplier_id' => 2,
            'nama_barang' => 'Gembok Anti-Cut 60mm',
            'kode_barang' => 'GAC60',
            'merek' => 'Sherlock',
            'harga_jual' => 30000,
            'deskripsi' => 'Anti Cut, ukuran 60mm',
            'foto' => 'foto_barang_supplier/gemboksherlock.jpg'
        ]);
        BarangSupplier::create([
            'supplier_id' => 2,
            'nama_barang' => 'Gembok Anti-Cut 50mm',
            'kode_barang' => 'GAC050',
            'merek' => 'Sherlock',
            'harga_jual' => 25000,
            'deskripsi' => 'Anti Cut, ukuran 50mm',
            'foto' => 'foto_barang_supplier/gemboksherlock.jpg'
        ]);
        BarangSupplier::create([
            'supplier_id' => 2,
            'nama_barang' => 'Gembok Anti-Cut 40mm',
            'kode_barang' => 'GAC040',
            'merek' => 'Sherlock',
            'harga_jual' => 20000,
            'deskripsi' => 'Anti Cut, ukuran 40mm',
            'foto' => 'foto_barang_supplier/gemboksherlock.jpg'
        ]);

        
        // PurchaseOrder::create([
        //     'supplier_id' => 1,
        //     'total_item' => 10,
        //     'total_harga' => 160000,
        //     'status' => 'Selesai'
        // ]);

        // DetailPurchaseOrder: :create([
        //     'purchase_order_id' => 1,
        //     'barang_supplier_id' => 1,
        //     'jumlah_item' => 5,
        //     'sub_total' => 100000
        // ]);
        // DetailPurchaseOrder::create([
        //     'purchase_order_id' => 1,
        //     'barang_supplier_id' => 2,
        //     'jumlah_item' => 5,
        //     'sub_total' => 60000
        // ]);

        
    }
}

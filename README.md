README - scmApp

## Supply Chain Management Bahan Bangunan Pada Toko Besi Guna Bangunan Dengan Metode Extreme Programming
Selamat datang di README aplikasi skripsi saya! Aplikasi ini merupakan hasil dari penelitian dan pengembangan sebagai bagian dari tugas akhir (skripsi) saya di Universitas Pembangunan Nasional Veteran Jakarta. Aplikasi ini dirancang untuk mempermudah pengelolaan bahan bangunan pada toko besi guna bangunan dan juga menghubungkan toko dengan supplier dan pembeli. Aplikasi ini adalah bagian penting dari portofolio saya di GitHub dan merupakan bukti nyata kemampuan saya dalam mengembangkan perangkat lunak.

## Fitur 
## Authentikasi Pengguna
Fitur Authentication dan Authorization menggunakan middleware

## Management Barang
Fitur pengelolaan barang dengan operasi CRUD: fitur-fiturnya meliputi:
<ul>
    <li>Tambah Barang</li>
    <li>Lihat Barang</li>
    <li>Edit Barang</li>
    <li>Hapus Barang</li>
</ul>

## Management Supplier
Fitur pengelolaan Supplier dengan operasi CRUD: fitur-fiturnya meliputi:
<ul>
    <li>Tambah Supplier</li>
    <li>Lihat Supplier</li>
    <li>Edit Supplier</li>
    <li>Hapus Supplier</li>
</ul>
Supplier dapat menawarkan barang dengan operasi CRUD

## Pemesanan (Purchase Order) dan Pembelian Barang Supplier
<ul>
    <li>
        Melakukan pemesanan barang yang disediakan oleh supplier
    </li>
    <li>
        Pencatatan data pemesanan dan pembelian barang
    </li>
    <li>
        Update persediaan barang secara otomatis ketika membuat data pembelian barang
    </li>
    <li>
        Supplier utama dari barang dapat melihat persediaan barang yang dipasok sehingga dapat langsung mengirim barang ketika barang sudah mencapai batas minimal
    </li>
</ul>



## Penjualan
<ul>
    <li>
        <b>Penjualan di toko</b>
        Admin sebagai kasir dapat membuat data penjualan dari transaksi yang dilakukan pembeli di toko
    </li>
    <li>
        <b>Penjualan Online</b>
        Pembeli dapat melakukan pembelian melalui fitur pembelian dalam sistem
    </li>
    <li>Cetak Nota Penjualan</li>
</ul>

## Economic Order Quantity (EOQ)
Perhitungan yang digunakan untuk menentukan jumlah paling ekonomis pada setiap kali pembelian barang ke supplier

## Single Moving Average (SMA)
Perhitungan yang digunakan untuk memprediksi jumlah penjualan selama setahun. Perhitungan SMA dilakukan dengan data penjualan minimal selama 3 bulan dan akan dihitung untuk 12 bulan. Jika terdapat data penjualan sebanyak 12 bulan maka SMA tidak dilakukan dan hanya akan menampilkan data penjualan tersebut.

## Reorder Point
Perhitungan yang digunakan untuk menentukan jumlah minimal persediaan barang

## Laporan
Fitur laporan berisi laporan sebagai berikut:
<ul>
    <li>Laporan Penjualan Barang</li>
    <li>Laporan Pembelian Barang</li>
    <li>Cetak Laporan Barang/Bulan</li>
</ul>

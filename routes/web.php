<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\Supplier;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckLevelUser;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangMasterController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\UserPelangganController;
use App\Http\Controllers\BarangSupplierController;
use App\Http\Controllers\DetailPembelianController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\DetailPurchaseOrderController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PengembalianDetailController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\VarianBarangController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


/*
User Level
0 => pembeli
1 => super-admin
2 => admin
3 => supplier
*/

/*
Status Penjualan
Aktif => Keranjang User Pembeli
Check Out => Sudah tidak aktif jadi ke halaman check out
Menunggu Pembayaran => check out selesai, menunggu pelanggan membayar
Menunggu Konfirmasi Toko=> Transaksi sudah dibayar pembeli menunggu konfirmasi toko (konfirmasi pembayaran masuk atau belum)
Ditolak => Jika pembayaran tidak ada
Diproses => Barang disiapkan oleh toko
Dikirim => Barang sedang dikirim
Selesai => Barang sudah diterima
*/

/*
Status Purchase Order
Aktif => Keranjang Purchase Order
Menunggu konfirmasi  => disetujui pemilik, dilanjutkan ke supplier (menunggu konfirmasi supplier)
Ditolak => PO ditolak oleh supplier
Selesai => Purchase Order diproeses oleh supplier menjadi pembelian

*/

/* 
Metode Pembayaran
0 => Cash
1 => EDC
2 => Transfer
*/

// Home
Route::controller(HomeController::class)->group(function(){
    Route::get('/', 'index')->name('home');
    Route::get('/detail_barang/{barang}', 'detailBarangHome')->name('detailBarangHome');
    Route::get('/registrasi', 'createPelanggan')->name('createPelangganUser');
    Route::post('/store_pelanggan', 'storePelanggan')->name('storePelangganUser');
});

// autentikasi
Route::controller(AuthController::class)->group(function(){
    Route::get('/login', 'login')->name('login');
    Route::post('/pengguna/autentikasi', 'authentication')->name('userAuth');
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('checkLevelUser:1,2,3');


// Middleware Super-admin dan Admin
Route::group(['middleware' => ['checkLevelUser:1,2']], function () {
    Route::prefix('admin')->group(function(){
        // Barang
        Route::prefix('/barang_master')->group(function () {
            Route::controller(BarangMasterController::class)->group(function(){
                Route::get('index', 'index')->name('indexBarangMaster');
                Route::get('create', 'create')->name('createBarangMaster');   
                Route::post('store', 'store')->name('storeBarangMaster');
                Route::get('edit/{barang}', 'edit')->name('editBarangMaster');
                Route::put('update/{barang}', 'update')->name('updateBarangMaster');
                Route::get('show/{barang}', 'show')->name('showBarangMaster');
                Route::delete('delete/{barang}', 'destroy')->name('deleteBarangMaster');
                // ke bawah untuk varian barang
                
            });
        });

        Route::prefix('/varian_barang')->group(function(){
            Route::controller(VarianBarangController::class)->group(function(){
                Route::get('create/barang_master/{barangMaster}', 'create')->name('createVarianBarang');
                Route::post('store', 'store')->name('storeVarianBarang');
                Route::get('show/{varianBarang}', 'show')->name('showVarianBarang');
                Route::get('edit/{varianBarang}', 'edit')->name('editVarianBarang');
                Route::put('update/{varianBarang}', 'update')->name('updateVarianBarang');
                Route::delete('delete{varianBarang}', 'destroy')->name('deleteVarianBarang');
                // update persediaan barang
                Route::get('edit_persediaan_barang/{varianBarang}', 'editPersediaanBarang')->name('editPersediaanBarang');
                Route::put('update_persediaan_barang/{persediaanBarang}', 'updatePersediaanBarang')->name('updatePersediaanBarang');
                Route::get('show/{varianBarang}/EOQ', 'hitungEOQ')->name('hitungEOQBarang');
                Route::put('update_pembelian_optimal/{varianBarang}', 'updatePembelianOptimal')->name('updatePembelianOptimal');
                Route::put('update_persediaan_minimal/{varianBarang}', 'updatePersediaanMinimal')->name('updatePersediaanMinimal');
                Route::get('show/{varianBarang}/SMA', 'hitungSMA')->name('hitungSMABarang');
                Route::get('show/{varianBarang}/ROP', 'hitungROP')->name('hitungROPBarang');
                Route::get('persediaan_minimal', 'indexBarangKurangDariMinimal')->name('indexBarangKurangDariMinimal');
                // Route::get('generate_kode_barang/{barang}', 'generateKodeBarang')->name('generateKodeBarang');
            });
        });

        // Kategori
        Route::prefix('/kategori')->group(function () {
            Route::controller(KategoriController::class)->group(function(){
                Route::get('index', 'index')->name('indexKategori');
                Route::get('create', 'create')->name('createKategori');
                Route::post('store', 'store')->name('storeKategori');
                Route::delete('delete/{kategori}', 'destroy')->name('deleteKategori');
            });
        });

        // Satuan
        Route::prefix('/satuan')->group(function () {
            Route::controller(SatuanController::class)->group(function(){
                Route::get('index', 'index')->name('indexSatuan');
                Route::get('create', 'create')->name('createSatuan');
                Route::post('store', 'store')->name('storeSatuan');
                Route::delete('delete/{satuan}', 'destroy')->name('deleteSatuan');
            });
        });

        // Supplier
        Route::prefix('/supplier')->group(function () {
            Route::controller(SupplierController::class)->group(function(){
                Route::get('index', 'index')->name('indexSupplier');
                Route::get('create', 'create')->name('createSupplier');
                Route::post('store', 'store')->name('storeSupplier');
                Route::get('edit/{supplier}', 'edit')->name('editSupplier');
                Route::put('update/{supplier}', 'update')->name('updateSupplier');
                Route::get('show/{supplier}', 'show')->name('showSupplier');
                Route::get('show/{supplier}/barang/{barangSupplier}', 'barangSupplier')->name('barangSupplier');
                Route::delete('delete/{supplier}', 'destroy')->name('deleteSupplier');
                Route::get('generate_kode_supplier/{supplier}', 'generateKodeSupplier')->name('generateKodeSupplier');
            });
        });

        // User
        Route::prefix('/user')->group(function () {
            Route::controller(UserController::class)->group(function() {
                Route::get('pegawai', 'pegawai')->name('indexUserPegawai');
                Route::get('sales', 'sales')->name('indexUserSales');
                Route::get('pelanggan', 'pelanggan')->name('indexUserPelanggan');
                Route::get('create', 'create')->name('createUser')->middleware();
                Route::post('store', 'store')->name('storeUser');
            });
        });

        // Pelanggan non-user
        Route::prefix('/pelanggan')->group(function () {
            Route::controller(PelangganController::class)->group(function(){
                Route::get('index', 'index')->name('indexPelanggan');
                Route::get('create', 'create')->name('createPelanggan');
                Route::post('store', 'store')->name('storePelangganBaru');
                Route::get('edit/{pelanggan}', 'edit')->name('editPelanggan');
                Route::put('update/{pelanggan}', 'update')->name('updatePelanggan');
                Route::delete('delete/{pelanggan}', 'delete')->name('deletePelanggan');
            });
        });

        // Penjualan Barang
        Route::prefix('/penjualan')->group(function () {
            Route::controller(PenjualanController::class)->group(function(){
                Route::get('index', 'index')->name('indexPenjualan');
                Route::get('index/selesai', 'indexSelesai')->name('indexPenjualanSelesai');
                Route::get('create', 'create')->name('createPenjualan');
                Route::post('store', 'store')->name('storePenjualan');
                Route::get('show/{penjualan}', 'show')->name('showPenjualan');
                Route::get('keranjang/{penjualan}', 'keranjangPenjualan')->name('keranjangPenjualan');
                Route::put('update_metode_pembayaran_pengiriman/{penjualan}', 'updateMetodePembayaranPengiriman')->name('updateMetodePembayaranPengiriman');
                Route::get('proses_transaksi_pembeli/{penjualan}', 'prosesPenjualanPembeli')->name('prosesPenjualanPembeli');
                Route::get('tolak_transaksi_pembeli/{penjualan}', 'tolakPenjualanPembeli')->name('tolakPenjualanPembeli');
                Route::put('input_supir_pengirim/{penjualan}', 'inputSupirPengirim')->name('inputSupirPengirim');
                Route::get('kirim/{penjualan}', 'kirim')->name('kirimPenjualan');
                Route::get('selesai/{penjualan}', 'selesai')->name('penjualanSelesai');
                Route::get('cetak_nota/{penjualan}', 'cetakNota')->name('cetakNotaPenjualan');
            });

            Route::controller(DetailPenjualanController::class)->group(function(){
                Route::post('add_barang', 'addBarang')->name('addBarangPenjualan'); 
                Route::post('update_jumlah_barang', 'updateJumlahBarang')->name('updateJumlahBarangPenjualan');
                Route::delete('delete/{detailPenjualan}', 'deleteBarangPenjualan')->name('deleteBarangPenjualan');
            });
        });

        // Purchase Order (pemesanan ke supplier dengan barang yang disediakan supplier)
        Route::prefix('purchase_order')->group(function() {
            Route::controller(PurchaseOrderController::class)->group(function() {
                Route::get('index', 'index')->name('indexPurchaseOrder');
                Route::get('create', 'create')->name('createPurchaseOrder');
                Route::get('show/{purchaseOrder}', 'show')->name('showPurchaseOrder');
                Route::post('store', 'store')->name('storePurchaseOrder');
                Route::get('keranjang/{purchaseOrder}', 'keranjang')->name('keranjangPurchaseOrder');
                Route::get('teruskan_ke_pemilik/{purchaseOrder}', 'teruskanKePemilik')->name('teruskanKePemilik');
                Route::get('teruskan_ke_supplier/{purchaseOrder}', 'teruskanKeSupplier')->name('teruskanKeSupplier');
                Route::get('batalkan_purchase_order/{purchaseOrder}', 'batalkanPurchaseOrder')->name('batalkanPurchaseOrder');
                Route::post('upload_bukti_penerimaan/{purchaseOrder}', 'uploadBuktiPenerimaan')->name('uploadBuktiPenerimaan');
            });
            Route::controller(DetailPurchaseOrderController::class)->group(function() {
                Route::post('storeBarang', 'store')->name('storeDetailPurchaseOrder');
                Route::put('updateJumlahBarang', 'update')->name('updataDetailPurchaseOrder');
                Route::delete('deleteBarang/{detailPurchaseOrder}', 'destroy')->name('deleteDetailPurchaseOrder');
            });
        });

        // Pembelian
        Route::prefix('pembelian')->group(function(){
            Route::controller(PembelianController::class)->group(function(){
                Route::get('index', 'index')->name('indexPembelian');
                Route::get('create', 'create')->name('createPembelian');
                Route::post('store', 'store')->name('storePembelian');
                Route::get('show/{pembelian}', 'show')->name('showPembelian');
                // Route::get('simpan/{pembelian}', 'simpan')->name('simpanPembelian');
                Route::get('keranjang/{pembelian}/po/{purchaseOrder}', 'keranjang')->name('keranjangPembelian');
                Route::get('simpan/{pembelian}', 'simpan')->name('simpanPembelian');
            });

            Route::controller(DetailPembelianController::class)->group(function() {
                Route::post('store/detail_pembelian', 'store')->name('storeDetailPembelian');
                Route::put('update/detail_pembelian/{detailPembelian}', 'update')->name('updateDetailPembelian');
                Route::delete('destroy/detail_pembelian/{detailPembelian}', 'destroy')->name('destroyDetailPembelian');
            });
        });

        // Pengembalian
        Route::prefix('pengembalian')->group(function(){
            Route::controller(PengembalianController::class)->group(function(){
                Route::get('index', 'index')->name('indexPengembalian');
                Route::get('store/{purchaseOrder}', 'store')->name('storePengembalian');
                Route::get('show/{pengembalian}', 'show')->name('showPengembalian');
                Route::get('simpan_pengembalian/{pengembalian}', 'simpanPengembalian')->name('simpanPengembalian');
                Route::get('keranjang_pengembalian/{pengembalian}', 'keranjangPengembalian')->name('keranjangPengembalian');
                Route::post('update_catatan/{pengembalian}', 'updateCatatan')->name('updateCatatanPengembalian');
            });

            Route::controller(PengembalianDetailController::class)->group(function(){
                Route::post('store/pengembalian_detail', 'store')->name('storePengembalianDetail');
                Route::put('update/pengembalian_detail/{pengembalianDetail}', 'update')->name('updatePengembalianDetail');
                Route::delete('destroy/pengembalian_detail/{pengembalianDetail}', 'destroy')->name('destroyPengembalianDetail');
            });
        });
    });
});



// User Pelanggan
Route::group(['middleware' => 'checkLevelUser: 0'], function(){
    Route::prefix('/user/pelanggan')->group(function(){
        Route::controller(UserPelangganController::class)->group(function(){
            Route::get('profile', 'profileUserPelanggan')->name('profileUserPelanggan');
            Route::get('profile/edit', 'profileEditPelanggan')->name('profileEditPelanggan');
            Route::get('profile/edit/password', 'editPasswordUserPelanggan')->name('editPasswordUserPelanggan');
            Route::put('profile/update/{user}', 'updateProfileUserPelanggan')->name('updateProfileUserPelanggan');
            Route::get('daftar_transaksi', 'daftarTransaksiUserPelanggan')->name('daftarTransaksiUserPelanggan');
            Route::get('transaksi/{penjualan}', 'detailTransaksiUserPelanggan')->name('detailTransaksiUserPelanggan');
            // Keranjang belanja
            Route::get('keranjang', 'keranjangBelanja')->name('keranjangBelanja');
            Route::post('add_barang_keranjang_belanja', 'addBarangKeranjangBelanja')->name('addBarangKeranjangBelanja');
            Route::put('update_jumlah_barang_keranjang_belanja', 'updateJumlahBarangKeranjangBelanja')->name('updateJumlahBarangKeranjangBelanja');
            Route::delete('delete_barang_keranjang_belanja/{detailPenjualan}/delete', 'deleteBarangKeranjangBelanja')->name('deleteBarangKeranjangBelanja');
            // check out
            Route::get('check_out/pemesanan/{penjualan}', 'checkOut')->name('checkOutPelanggan');
            Route::put('update_metode_pengiriman/{penjualan}', 'updateMetodePengiriman')->name('updateMetodePengirimanPelanggan');
            // pembayaran
            Route::get('pembayaran/pemesanan/{penjualan}', 'pembayaranPelanggan')->name('pembayaranPelanggan');
            Route::post('upload_bukti_pembayaran/pelanggan/{penjualan}', 'uploadBuktiPembayaran')->name('uploadBuktiPembayaran');
            // Selesai transaksi
            Route::get('transaksi/selesai/{penjualan}', 'selesai')->name('selesaiTransaksiPelanggan');
        });
        Route::controller(PenjualanController::class)->group(function(){
            Route::get('cetak_nota/{penjualan}', 'cetakNota')->name('cetakNotaPenjualanPelanggan');
        });
    });
});

// User Supplier
Route::group(['middleware' => 'checkLevelUser: 3'], function(){
    Route::prefix('supplier')->group(function(){
        Route::prefix('barang')->group(function(){
            Route::controller(BarangSupplierController::class)->group(function(){
                Route::get('index', 'index')->name('indexBarangSupplier');
                Route::get('create', 'create')->name('createBarangSupplier');
                Route::post('store', 'store')->name('storeBarangSupplier');
                Route::get('show/{barangSupplier}', 'show')->name('showBarangSupplier');
                Route::get('edit/{barangSupplier}', 'edit')->name('editBarangSupplier');
                Route::put('update/{barangSupplier}', 'update')->name('updateBarangSupplier');
                Route::delete('destoy/{barangSupplier}', 'destroy')->name('deleteBarangSupplier');
            });
        });

        Route::prefix('purchase_order')->group(function(){
            Route::controller(PurchaseOrderController::class)->group(function(){
                Route::get('index', 'indexPOSupplier')->name('indexPurchaseOrderSupplier');
                Route::get('show/{purchaseOrder}', 'showPOSupplier')->name('showPurchaseOrderSupplier');
                Route::get('proses/{purchaseOrder}', 'prosesPOSupplier')->name('prosesPurchaseOrderSupplier');
                Route::get('proses_order_supplier/{purchaseOrder}', 'prosesBuatPOSupplier')->name('prosesBuatPOSupplier');
                Route::post('update_kode_surat/{purchaseOrder}', 'updateKodePOSupplierNomorSuratInvoice')->name('updateKodePOSupplierNomorSuratInvoice');
                Route::get('tolak/{purchaseOrder}', 'tolakPOSupplier')->name('tolakPurchaseOrderSupplier');
                Route::post('upload_surat_jalan/{purchaseOrder}', 'uploadSuratJalan')->name('uploadSuratJalan');
                Route::post('upload_invoice_pembelian/{purchaseOrder}', 'uploadInvoice')->name('uploadInvoice');
                Route::get('create', 'createPurchaseOrderSupplier')->name('createPurchaseOrderSupplier');
                Route::get('keranjang_po/{purchaseOrder}', 'KeranjangPOSupplier')->name('keranjangPOSupplier');
                Route::get('teruskan_ke_pemilik/{purchaseOrder}', 'teruskanKePemilik')->name('teruskanKePemilikOlehSupplier');
            }); 
        });

        Route::prefix('barang_toko')->group(function(){
            Route::controller(BarangMasterController::class)->group(function(){
                Route::get('index', 'indexBarangMasterTokoUntukSupplier')->name('indexBarangMasterTokoUntukSupplier');
                Route::get('show/{barangMaster}', 'showBarangMasterTokoUntukSupplier')->name('showBarangMasterTokoUntukSupplier');
            });
            
            Route::prefix('varian_barang')->group(function(){
                Route::controller(VarianBarangController::class)->group(function(){
                    Route::get('show/{varianBarang}', 'showVarianBarangUntukSupplier')->name('showVarianBarangUntukSupplier');
                    Route::get('index_persediaan_minimal', 'indexBarangKurangDariMinimalUntukSupplier')->name('indexBarangKurangDariMinimalUntukSupplier');
                });
            });

            Route::controller(DetailPurchaseOrderController::class)->group(function() {
                Route::post('storeBarang', 'store')->name('storeDetailPurchaseOrderSupplier');
                Route::put('updateJumlahBarang', 'update')->name('updataDetailPurchaseOrderSupplier');
                Route::delete('deleteBarang/{detailPurchaseOrder}', 'destroy')->name('deleteDetailPurchaseOrderSupplier');
            });
        });

        Route::prefix('pengembalian_barang')->group(function(){
            Route::controller(PengembalianController::class)->group(function(){
                Route::get('index', 'indexPengembalianBarangSupplier')->name('indexPengembalianBarangSupplier');
                Route::get('show/{pengembalian}', 'showPengembalianBarangSupplier')->name('showPengembalianBarangSupplier');
            });
        });
    });
});

// Cetak Nota
Route::controller(PenjualanController::class)->group(function(){
    Route::get('cetak_nota/{penjualan}', 'cetakNota')->name('cetakNotaPenjualan');
});

// akses halaman laporan untuk pemilik
Route::group(['middleware' => 'checkLevelUser: 1'], function(){
    Route::prefix('laporan')->group(function(){
        Route::controller(LaporanController::class)->group(function(){
            Route::get('index', 'index')->name('indexLaporan');
            
            // Laporan Penjualan
            Route::get('/penjualan', 'indexLaporanPenjualan')->name('indexLaporanPenjualan');
            Route::get('/penjualan/perbulan', 'LaporanPenjualanPerbulan')->name('laporanPenjualanPerbulan');
            Route::get('/cetak/laporan_penjualan/{bulan}/{tahun}', 'cetakLaporanPenjualanPerbulan')->name('cetakLaporanPenjualanPerbulan');

            // Laporan Barang
            Route::get('barang', 'indexLaporanBarang')->name('indexLaporanBarang');
            Route::get('barang/{barang}/perbulan', 'LaporanPenjualanBarangPerbulan')->name('LaporanPenjualanBarangPerbulan');
            Route::get('barang/{barang}', 'LaporanPenjualanBarangById')->name('LaporanPenjualanBarangById');
            Route::get('cetak/laporan_barang/{barang}/{bulan}/{tahun}', 'cetakLaporanBarangPerbulan')->name('cetakLaporanBarangPerbulan');
            
            // Laporan Purchase Order
            Route::get('purchase_order', 'indexLaporanPurchaseOrder')->name('indexLaporanPurchaseOrder');
            Route::get('/purchase_order/perbulan', 'LaporanPurchaseOrderPerbulan')->name('LaporanPurchaseOrderPerbulan');
            Route::get( 'cetak/laporan_purchase_order/{bulan}/{tahun}', 'cetakLaporanPurchaseOrderPerbulan')->name('cetakLaporanPurchaseOrderPerbulan');

            // Laporan Pembelian
            Route::get('pembelian', 'indexLaporanPembelian')->name('indexLaporanPembelian');
            Route::get('/pembelian/perbulan', 'indexLaporanPembelianPerbulan')->name('indexLaporanPembelianPerbulan');
            Route::get('cetak/laporan_pembelian/{bulan}/{tahun}', 'cetakLaporanPembelianPerbulan')->name('cetakLaporanPembelianPerbulan');

        });
    });

    // supplier kerja sama
    Route::get('kerjasama_supplier/{supplier}', [SupplierController::class, 'kerjasamaDenganSupplier'])->name('kerjasamaDenganSupplier');
});

Route::group(['middleware' => 'checkLevelUser: 1,2,3'], function(){
    // profile admin dan supplier
    Route::prefix('profile')->group(function(){
        Route::controller(UserController::class)->group(function(){
            Route::get('/', 'profileUser')->name('profileUser');
            Route::get('edit', 'editProfileUser')->name('editProfileUser');
            Route::get('edit/password', 'editPasswordUser')->name('editPasswordUser');
            Route::put('update/{user}', 'updateProfileUser')->name('updateProfileUser');
        });
    });
});

// ubah password
Route::group(['middleware' => 'checkLevel: 0,1,2,3'], function(){
    Route::put('update_password/{user}', [UserController::class, 'updatePassword'])->name('updatePassword');
});

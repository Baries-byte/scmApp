<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\BarangMaster;
use App\Models\VarianBarang;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\BarangSupplier;
use App\Models\PersediaanBarang;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function index()
    {
        $BarangMaster = BarangMaster::count();
        $VarianBarang = VarianBarang::count();
        $Penjualan = Penjualan::where('status_transaksi', '!=', 'Aktif')
        ->where('status_transaksi', '!=', 'Check Out')
        ->where('status_transaksi', '!=', 'Menunggu Pembayaran')
        ->where('status_transaksi', '!=', 'Ditolak')
        ->where('status_transaksi', '!=', 'Selesai')
        ->count();
        $Supplier = Supplier::count();
        $Pelanggan = Pelanggan::count();
        $Pengguna = User::count();
        $PO = PurchaseOrder::where('status', '!=', 'selesai')
        ->where('status', '!=', 'Ditolak')
        ->count();
        $barangPersediaanMinimal = PersediaanBarang::whereColumn('jumlah', '<', 'persediaan_min')->count();

        // untuk dashboard supplier
        if(auth()->user()->level == 3)
        {
            $barangSupplier = BarangSupplier::where('supplier_id', '=', auth()->user()->supplier->id)->count();
            $POSupplier = PurchaseOrder::where('supplier_id', '=', auth()->user()->supplier->id)
            ->where('status', '!=', 'Aktif')
            ->where('status', '!=', 'Menunggu konfirmasi pemilik')
            ->where('status', '!=', 'Dibatalkan')
            ->where('status', '!=', 'Ditolak')
            ->where('status', '!=', 'Selesai')
            ->count();
            
            $supplierId = auth()->user()->supplier->id;

            $barangToko = DB::table('barang_master')
            ->join('varian_barang', 'barang_master.id', '=', 'varian_barang.barang_master_id')
            ->join('persediaan_barang', 'varian_barang.id', '=', 'persediaan_barang.varian_barang_id')
            ->where('barang_master.supplier_id', $supplierId)
            ->whereColumn('persediaan_barang.jumlah', '<', 'persediaan_barang.persediaan_min')
            ->select('varian_barang.*', 'persediaan_barang.*')
            ->count();

            // dd($barangToko);

            // $barangToko = VarianBarang::join('persediaan_barang', 'varian_barang.id', '=', 'persediaan_barang.varian_barang_id')
            // ->where('supplier_id', '=', auth()->user()->supplier->id)
            // ->whereColumn('persediaan_barang.jumlah', '<', 'persediaan_barang.persediaan_min')
            // ->count();

            return view('dashboardAdmin', [
                'barangSupplier' => $barangSupplier,
                'POSupplier' => $POSupplier,
                'barangToko' => $barangToko
            ]);
        }

        return view('dashboardAdmin', [
            'BarangMaster' => $BarangMaster,
            'VarianBarang' => $VarianBarang,
            'Supplier' => $Supplier,
            'Pelanggan' => $Pelanggan,
            'Pengguna' => $Pengguna,
            'Penjualan' => $Penjualan,
            'PO' => $PO,
            'barangPersediaanMinimal' => $barangPersediaanMinimal
        ]);

        // return view('dashboardAdmin');
    }
}

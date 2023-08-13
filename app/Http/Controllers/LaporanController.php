<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\VarianBarang;
use Illuminate\Http\Request;
use App\Models\BarangTerjual;
use App\Models\PurchaseOrder;
use App\Models\DetailPembelian;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    //

    public function index()
    {
        return view('laporan.indexLaporan');    
    }

    public function indexLaporanPenjualan()
    {
        $penjualan = Penjualan::where('status_transaksi', '=', 'Selesai')->orderBy('created_at', 'desc')->paginate(20);
        $totalPemasukan = Penjualan::where('status_transaksi', '=', 'Selesai')->sum('total_harga');
        $totalItemTerjual = Penjualan::where('status_transaksi', '=', 'Selesai')->sum('total_item');
        // dd($penjualan);
        return view('laporan.penjualan.indexLaporanPenjualan', [
            'penjualan' => $penjualan,
            'totalPemasukan' => $totalPemasukan,
            'totalItemTerjual' => $totalItemTerjual
        ]);
    }

    public function indexLaporanPembelian()
    {
        $pembelian = Pembelian::orderBy('created_at', 'desc')->paginate(20);
        $totalItem = Pembelian::sum('total_item');

        return view('laporan.pembelian.indexLaporanPembelian', [
            'pembelian' => $pembelian,
            'totalItem' => $totalItem
        ]);
    }

    public function indexLaporanPurchaseOrder()
    {
        $purchaseOrder = PurchaseOrder::where('status', '=', 'Selesai')->orderBy('created_at', 'desc')->paginate(20);
        $totalItem = PurchaseOrder::where('status', '=', 'Selesai')->sum('total_item');
        $totalHarga = PurchaseOrder::where('status', '=', 'Selesai')->sum('total_harga');
        return view('laporan.purchaseOrder.indexLaporanPurchaseOrder', [
            'purchaseOrder' => $purchaseOrder,
            'totalItem' => $totalItem,
            'totalHarga' => $totalHarga
        ]);
    }

    public function indexLaporanPembelianPerbulan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = date('Y', strtotime($bulan));
        $bulan = date('m', strtotime($bulan));


        $pembelian = Pembelian::whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->orderBy('created_at')
        ->paginate(20);

        $totalItem = Pembelian::whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->orderBy('created_at')
        ->sum('total_item');

        return view('laporan.pembelian.indexLaporanPembelianPerbulan', [
            'pembelian' => $pembelian,
            'totalItem' => $totalItem,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
    }

    public function LaporanPurchaseOrderPerbulan(Request $request)
    {
        $bulan = $request->bulan;

        $tahun = date('Y', strtotime($bulan));
        $bulan = date('m', strtotime($bulan));

        $purchaseOrder = PurchaseOrder::where('status', '=', 'Selesai')
        ->whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->orderBy('created_at')
        ->paginate(20);

        $totalItem = PurchaseOrder::where('status', '=', 'Selesai')
        ->whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->sum('total_item');

        $totalHarga = PurchaseOrder::where('status', '=', 'Selesai')
        ->whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->sum('total_harga');

        return view('laporan.purchaseOrder.laporanPurchaseOrderPerbulan', [
            'purchaseOrder' => $purchaseOrder,
            'totalItem' => $totalItem,
            'totalHarga' => $totalHarga,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
    }

    public function LaporanPenjualanPerbulan(Request $request)
    {
        $bulan = $request->bulan;

        $tahun = date('Y', strtotime($bulan));
        $bulan = date('m', strtotime($bulan));

        $penjualan = Penjualan::where('status_transaksi', '=', 'Selesai')
        ->whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->orderBy('created_at', 'desc')
        ->get();
        
        $totalPemasukan = Penjualan::where('status_transaksi', '=', 'Selesai')
        ->whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->sum('total_harga');

        $totalItemTerjual = Penjualan::where('status_transaksi', '=', 'Selesai')
        ->whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->sum('total_item');
        
        // dd($totalPemasukan);
        return view('laporan.penjualan.laporanPenjualanPerbulan', [
            'penjualan' => $penjualan,
            'totalPemasukan' => $totalPemasukan,
            'totalItemTerjual' => $totalItemTerjual,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
    }

    public function cetakLaporanPenjualanPerbulan($bulan, $tahun)
    {
        $penjualan = Penjualan::where('status_transaksi', '=', 'Selesai')
        ->whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->orderBy('created_at')
        ->get();
        
        $totalPemasukan = Penjualan::where('status_transaksi', '=', 'Selesai')
        ->whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->sum('total_harga');

        $totalItemTerjual = Penjualan::where('status_transaksi', '=', 'Selesai')
        ->whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->sum('total_item');

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.laporanPenjualanPerbulan', compact('penjualan', 'bulan', 'tahun', 'totalPemasukan', 'totalItemTerjual'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('laporanPenjualan.pdf');
    }

    public function cetakLaporanPembelianPerbulan($bulan, $tahun)
    {
        $pembelian = Pembelian::whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->orderBy('created_at')
        ->get();

        $totalItem = Pembelian::whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->orderBy('created_at')
        ->sum('total_item');

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.laporanPembelianPerbulan', compact('pembelian', 'bulan', 'tahun', 'totalItem'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('laporanPembelian.pdf');
    }

    public function cetakLaporanPurchaseOrderPerbulan($bulan, $tahun)
    {
        $purchaseOrder = PurchaseOrder::where('status', '=', 'Selesai')
        ->whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->orderBy('created_at')
        ->get();

        $totalItem = PurchaseOrder::where('status', '=', 'Selesai')
        ->whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->sum('total_item');

        $totalHarga = PurchaseOrder::where('status', '=', 'Selesai')
        ->whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->sum('total_harga');

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.laporanPurchaseOrderPerbulan', compact('purchaseOrder', 'bulan', 'tahun', 'totalItem', 'totalHarga'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('laporanPurchaseOrder.pdf');
    }

    public function indexLaporanbarang()
    {
        $dataBarangTerjual = BarangTerjual::select('varian_barang_id', 'nama_varian_barang', 'kode_barang', DB::raw('SUM(barang_terjual.jumlah) as total_terjual'))
        ->join('varian_barang', 'varian_barang.id', '=', 'barang_terjual.varian_barang_id')
        ->groupBy('varian_barang_id', 'nama_varian_barang', 'kode_barang')
        ->get();
        
        // dd($dataBarangTerjual);
        
        return view('laporan.barang.indexLaporanBarang', [
            'barangTerjual' => $dataBarangTerjual,
        ]);
    }

    public function LaporanPenjualanBarangById(VarianBarang $barang){
        // $dataBarang = BarangTerjual::select(DB::raw('DATE(barang_terjual.created_at) as tanggal', ))
        // data diambil dari tabel barang_terjual
        $dataLaporanBarangById = BarangTerjual::select('varian_barang_id', 'created_at', 'jumlah')
        ->where('varian_barang_id', '=', $barang->id)
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        $jumlahTerjual = $dataLaporanBarangById->sum('jumlah');

        // dd($dataLaporanBarangById);
        
        return view('laporan.barang.laporanPerBarang', [
            'barang' => $barang,
            'dataLaporan' => $dataLaporanBarangById,
            'jumlahTerjual' => $jumlahTerjual
        ]);
    }

    public function LaporanPenjualanBarangPerbulan(Request $request, VarianBarang $barang)
    {
        $bulan = $request->bulan;

        $tahun = date('Y', strtotime($bulan));
        $bulan = date('m', strtotime($bulan));

        $dataLaporanBarangPerbulan = BarangTerjual::select('varian_barang_id', 'created_at', 'jumlah')
        ->where('varian_barang_id', '=', $barang->id)
        ->whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->orderBy('created_at')
        ->get();

        $totalTerjual = $dataLaporanBarangPerbulan->sum('jumlah');
        // dd($dataLaporanBarangPerbulan);

        // $jumlahTerjual = $dataLaporanBarangById->sum('jumlah');

        return view('laporan.barang.laporanBarangPerbulan', [
            'barang' => $barang,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'dataLaporanBarangPerbulan' => $dataLaporanBarangPerbulan,
            'totalTerjual' => $totalTerjual
        ]);
    }

    public function cetakLaporanBarangPerbulan($barang, $bulan, $tahun)
    {
        
        $barang = VarianBarang::find($barang);
        // dd($barang);
        $dataLaporanBarangPerbulan = BarangTerjual::select('varian_barang_id', 'created_at', 'jumlah')
        ->where('varian_barang_id', '=', $barang->id)
        ->whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->orderBy('created_at')
        ->get();

        $totalTerjual = $dataLaporanBarangPerbulan->sum('jumlah');

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.laporanBarangPerbulan', compact('barang', 'bulan', 'tahun', 'dataLaporanBarangPerbulan', 'totalTerjual'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('laporanBarang.pdf');
    }
    
}

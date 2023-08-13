<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\BarangDibeli;
use App\Models\BarangMaster;
use App\Models\VarianBarang;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\DetailPembelian;

class PembelianController extends Controller
{
    // daftar pembelian
    public function index()
    {
        $pembelian = Pembelian::latest()->paginate(20);
        // dd($pembelian);
        
        return view('pembelian.indexPembelian', [
            'pembelian' => $pembelian
        ]);
    }

    // halaman tambah pembelian
    // passing purchase order yang sudah selesai
    public function create()
    {
        $purchaseOrder = PurchaseOrder::where('status', '=', 'Selesai')->filter(request(['search']))->paginate(20);

        return view('pembelian.createPembelian', [
            'purchaseOrder' => $purchaseOrder
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $pembelian = new Pembelian;
        $pembelian->purchase_order_id = $request->purchase_order_id;
        $pembelian->total_item = 0;
        $pembelian->save();

        return redirect()->route('keranjangPembelian', ['pembelian' => $pembelian->id, 'purchaseOrder' => $request->purchase_order_id])->with('success', 'Pembelian berhasil dibuat');
    }

    public function keranjang(Pembelian $pembelian)
    {
        $purchaseOrder = PurchaseOrder::where('id', '=', $pembelian->purchase_order_id)->first();
        $supplier_id = $purchaseOrder->supplier_id;
        $barangMaster = BarangMaster::where('supplier_id', $supplier_id)->get();
        $varianBarang = VarianBarang::whereIn('barang_master_id', $barangMaster->pluck('id'))->get();
        // dd($varianBarang);
        // $barang = VarianBarang::where('supplier_id', '=', $purchaseOrder->supplier_id)->paginate(5);
        $detailPembelian = DetailPembelian::where('pembelian_id', '=', $pembelian->id)->get();

        $jumlahItem = DetailPembelian::where('pembelian_id', '=', $pembelian->id)->sum('jumlah_item');

        $pembelian->total_item = $jumlahItem;
        $pembelian->save();

        // dd($detailPembelian);

        return view('pembelian.keranjangPembelian', [
            'pembelian' => $pembelian,
            'purchaseOrder' => $purchaseOrder,
            'barang' => $varianBarang,
            'detailPembelian' => $detailPembelian,
            'jumlahItem' => $jumlahItem
        ]);
    }

    public function show(Pembelian $pembelian)
    {
        $purchaseOrder = PurchaseOrder::where('id', '=', $pembelian->purchase_order_id)->first();
        $detailPembelian = DetailPembelian::where('pembelian_id', '=', $pembelian->id)->get();
        $jumlahItem = DetailPembelian::where('pembelian_id', '=', $pembelian->id)->sum('jumlah_item');

        $pembelian->total_item = $jumlahItem;
        $pembelian->save();

        return view('pembelian.showPembelian', [
            'purchaseOrder' => $purchaseOrder,
            'detailPembelian' => $detailPembelian,
            'jumlahItem' => $jumlahItem
        ]);
    }

    public function simpan (Pembelian $pembelian)
    {
        // dd($pembelian->detailPembelian);

        foreach($pembelian->detailPembelian as $dp)
        {
            $barangDibeli = new BarangDibeli;
            $barangDibeli->varian_barang_id = $dp->varian_barang_id;
            $barangDibeli->jumlah = $dp->jumlah_item;
            $barangDibeli->save();
        }

        return redirect()->route('indexPembelian')->with('success', 'Pembelian disimpan, jumlah barang berhasil ditambah.');
    }
}

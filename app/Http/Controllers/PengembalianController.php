<?php

namespace App\Http\Controllers;

use App\Models\BarangSupplier;
use App\Models\Pengembalian;
use App\Models\PengembalianDetail;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    // index
    public function index()
    {
        $pengembalian = Pengembalian::get();
        return view('pengembalian.indexPengembalian', ['pengembalian' => $pengembalian]);
    }

    public function store(PurchaseOrder $purchaseOrder)
    {
        $pengembalian = new Pengembalian();
        $pengembalian->purchase_order_id = $purchaseOrder->id;
        $pengembalian->total_item = 0;
        $pengembalian->save();
        // dd($pengembalian);

        return redirect()->route('keranjangPengembalian', ['pengembalian' => $pengembalian->id]);
    }

    public function show(Pengembalian $pengembalian)
    {
        $purchaseOrder = PurchaseOrder::where('id', $pengembalian->purchase_order_id)->first();
        $supplier = Supplier::where('id', $purchaseOrder->supplier_id)->first();
        $barangSupplier = BarangSupplier::where('supplier_id', $supplier->id)->paginate(5);

        $pengembalianDetail = PengembalianDetail::where('pengembalian_id', $pengembalian->id)->get();

        return view('pengembalian.showPengembalian', ['pengembalian' => $pengembalian, 'purchaseOrder' => $purchaseOrder, 'barangSupplier' => $barangSupplier, 'pengembalianDetail' => $pengembalianDetail]);
    }

    public function keranjangPengembalian(Pengembalian $pengembalian)
    {
        $purchaseOrder = PurchaseOrder::where('id', $pengembalian->purchase_order_id)->first();
        $supplier = Supplier::where('id', $purchaseOrder->supplier_id)->first();
        $barangSupplier = BarangSupplier::where('supplier_id', $supplier->id)->paginate(5);

        $pengembalianDetail = PengembalianDetail::where('pengembalian_id', $pengembalian->id)->get();

        // dd($pengembalianDetail);
        return view('pengembalian.keranjangPengembalian', ['pengembalian' => $pengembalian, 'purchaseOrder' => $purchaseOrder, 'barangSupplier' => $barangSupplier, 'pengembalianDetail' => $pengembalianDetail]);
    }

    public function updateCatatan(Pengembalian $pengembalian, Request $request)
    {
        $pengembalian->catatan = $request->catatan;
        $pengembalian->save();

        return back()->with('success', 'Catatan berhasil pengembalian barang berhasil ditambahkan');
    }

    public function simpanPengembalian(Pengembalian $pengembalian)
    {
        return redirect()->route('showPengembalian', ['pengembalian' => $pengembalian->id])->with('success', 'Pengembalian berhasil disimpan dan dikirim ke supplier');
    }

    public function indexPengembalianBarangSupplier()
    {
        $supplierId = auth()->user()->supplier->id;
        $purchaseOrder = PurchaseOrder::where('supplier_id', $supplierId)->get();
        $pengembalian = Pengembalian::whereIn('purchase_order_id', $purchaseOrder->pluck('id'))->get();
        // dd($pengembalian);

        return view('supplier.pengembalian.indexPengembalianBarangSupplier', ['pengembalian' => $pengembalian]);
    }

    public function showPengembalianBarangSupplier(Pengembalian $pengembalian)
    {
        $purchaseOrder = PurchaseOrder::where('id', $pengembalian->purchase_order_id)->first();
        $supplier = Supplier::where('id', $purchaseOrder->supplier_id)->first();
        $barangSupplier = BarangSupplier::where('supplier_id', $supplier->id)->paginate(5);

        $pengembalianDetail = PengembalianDetail::where('pengembalian_id', $pengembalian->id)->get();

        return view('supplier.pengembalian.showPengembalianBarangSupplier', ['pengembalian' => $pengembalian, 'purchaseOrder' => $purchaseOrder, 'barangSupplier' => $barangSupplier, 'pengembalianDetail' => $pengembalianDetail]);
    }
}

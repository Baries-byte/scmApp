<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangSupplier;
use App\Models\DetailPurchaseOrder;
use App\Models\PurchaseOrder;

class DetailPurchaseOrderController extends Controller
{
    // store barang ke detail purchase order
    // cek sudah ada barang atau belum
    // kalau sudah ada tambah jumlah barang
    // kalau belum ada tambah barang ke detail purchase order
    public function store(Request $request)
    {
        $adaBarang = DetailPurchaseOrder::where('purchase_order_id', '=', $request->purchase_order_id)
        ->where('barang_supplier_id', '=', $request->barang_supplier_id)->first();
        // dd($purchaseOrder);

        if($request->jumlah_barang <= 0){
            return back()->with('info', 'Jumlah barang tidak boleh kurang dari 1');
        }

        if($adaBarang == true) {
            // dd("sudah ada barang");
            // dd($adaBarang);
            $adaBarang->jumlah_item += $request->jumlah_barang;
            $adaBarang->sub_total += ($request->jumlah_barang * $request->harga_jual);
            $adaBarang->save();

            return back()->with('success', 'Jumlah barang berhasil ditambah');
        }

        // belum ada barang di detail purchase order
        // store data barang di purchase order
        $detailPurchaseOrder = new DetailPurchaseOrder();
        $detailPurchaseOrder->purchase_order_id = $request->purchase_order_id;
        $detailPurchaseOrder->barang_supplier_id = $request->barang_supplier_id;
        $detailPurchaseOrder->jumlah_item = $request->jumlah_barang;
        $detailPurchaseOrder->sub_total = $request->jumlah_barang * $request->harga_jual;
        $detailPurchaseOrder->save();

        return back()->with('success', 'Barang berhasil ditambah ke purchase order');
    }

    public function update(Request $request) 
    {
        if($request->jumlah_barang < 1){
            return back()->with('info', 'Jumlah barang tidak boleh kurang dari 1');
        }
        
        $detailPurchaseOrder = DetailPurchaseOrder::where('purchase_order_id', '=', $request->purchase_order_id)->where('barang_supplier_id', '=', $request->barang_supplier_id)->first();
        

        // update jumlah dan sub_total
        $detailPurchaseOrder->jumlah_item = $request->jumlah_barang;
        $detailPurchaseOrder->sub_total = $request->jumlah_barang * $request->harga_jual;
        $detailPurchaseOrder->save();

        return back()->with('success', 'Jumlah barang berhasil diubah');
    }

    public function destroy(DetailPurchaseOrder $detailPurchaseOrder)
    {
        $detailPurchaseOrder->delete();
        return back()->with('delete', 'Barang berhasil dihapus dari purchase order');
    }
}

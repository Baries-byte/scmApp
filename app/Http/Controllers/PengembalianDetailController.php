<?php

namespace App\Http\Controllers;

use App\Models\PengembalianDetail;
use Illuminate\Http\Request;

class PengembalianDetailController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    //simpan detial pembelian
    // cek barang klo ada barang itu tambah jumlah
    public function store(Request $request)
    {
        // dd($request);
        $barangDiKeranjang = PengembalianDetail::where('pengembalian_id', '=', $request->pengembalian_id)
        ->where('barang_supplier_id', '=', $request->barang_supplier_id)->first();

        if($request->jumlah_barang <= 0) {
            return back()->with('delete', 'Jumlah barang tidak boleh kurang dari 1');
        }

        if($barangDiKeranjang == false){
            
            // dd($barangDiKeranjang);
            $detailPengembalian = new PengembalianDetail;
            $detailPengembalian->pengembalian_id = $request->pengembalian_id;
            $detailPengembalian->barang_supplier_id = $request->barang_supplier_id;
            $detailPengembalian->jumlah_item = $request->jumlah_barang;
            $detailPengembalian->save();
            
            return back()->with('success', 'Barang berhasil ditambah ke pembelian');
        }

        $barangDiKeranjang->jumlah_item += $request->jumlah_barang;
        $barangDiKeranjang->save();

        return back()->with('success', 'Jumlah barang berhasil ditambah');
    }

    public function destroy(PengembalianDetail $pengembalianDetail)
    {
        $pengembalianDetail->delete();

        return back()->with('delete', 'Barang berhasil dihapus dari pembelian');
    }

    public function update(PengembalianDetail $pengembalianDetail, Request $request)
    {
        if($request->jumlah_barang <= 0) {
            return back()->with('delete', 'Jumlah barang tidak boleh kurang dari 1');
        }

        $pengembalianDetail->jumlah_item = $request->jumlah_barang;
        $pengembalianDetail->save();

        // $pembelian

        return back()->with('success', 'Jumlah barang berhasil diperbarui');
    }
}

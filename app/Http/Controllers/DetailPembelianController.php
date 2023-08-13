<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Illuminate\Http\Request;
use App\Models\DetailPembelian;

class DetailPembelianController extends Controller
{
    //simpan detial pembelian
    // cek barang klo ada barang itu tambah jumlah
    public function store(Request $request)
    {
        // dd($request);
        $barangDiKeranjang = DetailPembelian::where('pembelian_id', '=', $request->pembelian_id)
        ->where('varian_barang_id', '=', $request->varian_barang_id)->first();

        if($request->jumlah <= 0) {
            return back()->with('delete', 'Jumlah barang tidak boleh kurang dari 1');
        }

        if($barangDiKeranjang == false){
            
            // dd($barangDiKeranjang);
            $detailPembelian = new DetailPembelian;
            $detailPembelian->pembelian_id = $request->pembelian_id;
            $detailPembelian->varian_barang_id = $request->varian_barang_id;
            $detailPembelian->jumlah_item = $request->jumlah;
            $detailPembelian->save();
            
            return back()->with('success', 'Barang berhasil ditambah ke pembelian');
        }

        $barangDiKeranjang->jumlah_item += $request->jumlah;
        $barangDiKeranjang->save();

        return back()->with('success', 'Jumlah barang berhasil ditambah');
    }

    public function destroy(DetailPembelian $detailPembelian)
    {
        $detailPembelian->delete();

        return back()->with('delete', 'Barang berhasil dihapus dari pembelian');
    }

    public function update(DetailPembelian $detailPembelian, Request $request)
    {
        if($request->jumlah <= 0) {
            return back()->with('delete', 'Jumlah barang tidak boleh kurang dari 1');
        }

        $detailPembelian->jumlah_item = $request->jumlah;
        $detailPembelian->save();

        // $pembelian

        return back()->with('success', 'Jumlah barang berhasil diperbarui');
    }
}

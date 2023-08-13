<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\VarianBarang;
use Illuminate\Http\Request;
use App\Models\DetailPenjualan;
use App\Events\DetailPenjualanCreated;

class DetailPenjualanController extends Controller
{
    // add barang ke penjualan
    // cek barang sudah ada di nota atau belum
    // kalau sudah ada tambah jumlah barang ke detail penjualan yang sudah ada
    // kalau belum ada tambah barang ke nota 
    public function addBarang(Request $request)
    {
        $barang = VarianBarang::where('id', '=', $request->barang_id)->first();
        $penjualan = Penjualan::where('id', '=', $request->penjualan_id)->first();
        $adaBarang = DetailPenjualan::where('penjualan_id', '=', $request->penjualan_id)
        ->where('varian_barang_id', '=', $request->barang_id)->first();

        // dd($adaBarang);

        if($adaBarang == true){
            if ($request->jumlah > 0) {
                if ($request->jumlah <= $barang->persediaan->jumlah) 
                {
                    if(($adaBarang->jumlah_item + $request->jumlah) > $barang->persediaan->jumlah)
                    {
                        return back()->with('delete', 'Persediaan barang tidak cukup.');
                    }
                     // update jumlah barang
                    $adaBarang->jumlah_item = $adaBarang->jumlah_item + $request->jumlah;
                    $adaBarang->sub_total = $adaBarang->jumlah_item * $request->harga_jual;
                    $adaBarang->save();
    
                     // update harga_total dan jumlah_barang ke penjualan
                    $penjualan->total_harga = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->sum('sub_total');
                    $penjualan->total_item = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->sum('jumlah_item');
                    $penjualan->save();
    
                    return back()->with('success', 'Jumlah barang berhasil diperbarui.');
                    
                }
                return back()->with('delete', 'Persediaan barang tidak cukup.');
            }
        }

        if($request->jumlah > 0) {

            if ($request->jumlah <= $barang->persediaan->jumlah) {

                // insert barang ke detail penjualan
                $detailPenjualan = new DetailPenjualan();
                $detailPenjualan->penjualan_id = $request->penjualan_id;
                $detailPenjualan->varian_barang_id = $request->barang_id;
                $detailPenjualan->jumlah_item = $request->jumlah;
                $detailPenjualan->sub_total = $request->harga_jual * $request->jumlah;
                $detailPenjualan->save();


                // update harga_total dan jumlah_barang ke penjualan
                $penjualan->total_harga = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->sum('sub_total');
                $penjualan->total_item = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->sum('jumlah_item');
                $penjualan->save();

                return back()->with('success', 'Barang berhasil ditambah ke transaksi penjualan');
            }
            return back()->with('delete', 'Persediaan barang tidak cukup.');
        }

        return back()->with('info', 'Jumlah barang minimal 1.');
    }

    // update jumlah barang
    public function updateJumlahBarang(Request $request)
    {
        $detailPenjualan = DetailPenjualan::find($request->id);
        $penjualan = Penjualan::where('id', '=', $request->penjualan_id)->first();
        $barang = VarianBarang::where('id', '=', $request->barang_id)->first();

        if ($request->jumlah > 0) {

            if ($request->jumlah <= $barang->persediaan->jumlah) {
                // update jumlah barang
                $detailPenjualan->jumlah_item = $request->jumlah;
                $detailPenjualan->sub_total = ($request->jumlah * $request->harga_jual);
                $detailPenjualan->save();

                // update harga_total dan jumlah_barang ke penjualan
                $penjualan->total_harga = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->sum('sub_total');
                $penjualan->total_item = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->sum('jumlah_item');
                $penjualan->save();

                return back()->with('success', 'Jumlah barang berhasil diperbarui.');
            }
            return back()->with('delete', 'Persediaan barang tidak cukup.');
        }
        return back()->with('info', 'Jumlah barang tidak boleh kurang dari 1.');
    }

    public function deleteBarangPenjualan(DetailPenjualan $detailPenjualan)
    {
        // variable penjualan
        $penjualan = Penjualan::where('id', '=', $detailPenjualan->penjualan_id)->first();

        //hapus barang dari database detail_penjualan 
        $detailPenjualan->delete();

        // update harga_total dan jumlah_barang ke penjualan
        $penjualan->total_harga = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->sum('sub_total');
        $penjualan->total_item = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->sum('jumlah_item');
        $penjualan->save();

        return back()->with('delete', 'Barang berhasil dihapus dari pesanan.');
    }
}

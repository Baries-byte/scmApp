<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class EoqController extends Controller
{
    //
    public function index(Barang $barang, Request $request)
    {
        $permintaan = $request->permintaan;
        $biayaPembelian = $request->biayaPembelian;
        $biayaPenyimpanan = $request->biayaPenyimpanan;

        $EOQ = hitungEOQ($permintaan, $biayaPembelian, $biayaPenyimpanan);

        return view('hitungEOQ', [
            'permintaan' => $permintaan,
            'biayaPembelian' => $biayaPembelian,
            'biayaPenyimpanan' => $biayaPenyimpanan,
            'EOQ' => $EOQ
        ]);
    }
}

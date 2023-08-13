<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\BarangTerjual;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SMAController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Barang $barang)
    {
        // Ambil data penjualan barang dari tabel "barang_terjual"

        // Ambil Data 12 bulan untuk ditampilkan 
        $dataPenjualanBarangTampil = BarangTerjual::select('barang_id',
        (DB::raw('MONTH(created_at) as bulan')),
        (DB::raw('YEAR(created_at) as tahun')),  
        (DB::raw('SUM(jumlah) as jumlah'))
        )
        ->where('barang_id', '=', $barang->id)
        ->groupBy('bulan', 'tahun', 'barang_id')
        ->orderBy('tahun', 'asc')
        ->orderBy('bulan', 'asc')
        ->get();

        // Ambil Data 12 bulan aja untuk perhitungan SMA
        $dataPenjualanBarang = BarangTerjual::select('barang_id',
        (DB::raw('MONTH(created_at) as bulan')),
        (DB::raw('YEAR(created_at) as tahun')),  
        (DB::raw('SUM(jumlah) as jumlah'))
        )
        ->where('barang_id', '=', $barang->id)
        ->groupBy('bulan', 'tahun', 'barang_id')
        ->orderBy('tahun', 'desc')
        ->orderBy('bulan', 'desc')
        ->get();

        // Ambil data field jumlah lalu dijadikan array
        $dataPenjualan = $dataPenjualanBarang->pluck('jumlah')->toArray();

        // Balik data dari bulan terlama ke terakhir
        // Karena data dari database diambil dari yg paling baru ke belakang
        $data = array_reverse($dataPenjualan);

        // Jika Datanya ada 12 bulan maka perhitungan SMA tidak dilakukan
        // Bisa langsung digunakan untuk perhitungan EOQ

        $totalPenjualanSetahun = $dataPenjualanBarangTampil->sum('jumlah');
        
        if(count($data) >= 12)
        {
            return view('perhitunganSMA', [
                'barang' => $barang,
                'dataPenjualanBarang' => $dataPenjualanBarangTampil,
                'totalSetahun' => $totalPenjualanSetahun
            ]);
        }

        // Perhitungan SMA
        $periode = 3; // Periode SMA
        $totalData = count($data);

        $sma = []; // data perhitungan sma data penjualan

        for ($i = 0; $i <= $totalData - $periode; $i++) {
            $sma[] = array_sum(array_slice($data, $i, $periode)) / $periode;
        }

        $smaPrediksi[] = end($sma);
        $dataAktualSmaPrediksi = array_merge($data, $smaPrediksi); // Data gabungan dari data penjualan dan $smaPrediksi untuk prediksi selama setahun

        $smaBaru = [];

        $totalData = 12;
        
        for ($i = 0; $i <= $totalData - $periode; $i++) {

            if(count($dataAktualSmaPrediksi) == $totalData)
            {
                $dataAktualSmaPrediksi;
            }
            $smaBaru[] = array_sum(array_slice($dataAktualSmaPrediksi, $i, $periode)) / $periode;
            $dataAktualSmaPrediksi[] = end($smaBaru);
        }

        $dataPrediksiSetahun = array_slice($dataAktualSmaPrediksi,0, 12);
        // dd($dataPenjualanBarang, $dataPrediksiSetahun);

        $dataPrediksiSetahunFloat = array_map('floatval', $dataPrediksiSetahun);
        $totalPrediksiSetahun = array_sum($dataPrediksiSetahunFloat);


        // dd($dataPrediksiSetahunFloat);

        return view('perhitunganSMA', [
            'barang' => $barang,
            'dataPenjualanBarang' => $dataPenjualanBarangTampil,
            'dataPrediksiSMASetahun' => $dataPrediksiSetahun,
            'totalPrediksiSetahun' => $totalPrediksiSetahun
        ]);
    }
}

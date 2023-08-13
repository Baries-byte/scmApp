<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\VarianBarang;
use Illuminate\Http\Request;
use App\Models\BarangTerjual;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\View;

class PenjualanController extends Controller
{
    //authentication
    public function __construct()
    {
        $this->middleware('auth');
    }

    // menampilkan seluruh data transaksi penjualan
    public function index()
    {
        // $penjualanAktifOnline = Penjualan::where('status_transaksi', '=', 'Menunggu Konfirmasi Toko')
        // ->orWhere('status_transaksi', '=', 'Diproses')
        // ->orWhere('status_transaksi', '=', 'Dikirim')
        // ->latest()
        // ->filter(request(['search_penjualanAktif']))
        // ->get();

        // $penjualanAktifOffline = Penjualan::where('user_id')
        // $penjualanOnline = Penjualan::where('status_transaksi', '=', 'Menunggu Konfirmasi Toko')->get();

        $penjualanAktif = Penjualan::where('status_transaksi', '!=', 'Selesai')
        ->where('status_transaksi', '!=', 'Check Out')
        ->where('status_transaksi', '!=', 'Menunggu Pembayaran')
        ->where('status_transaksi', '!=', 'Aktif')
        ->filter(request(['search_penjualan_aktif']))
        ->paginate(20);

        return view('penjualan.indexPenjualan', [
            'penjualanAktif' => $penjualanAktif,
        ]);
    }

    public function indexSelesai()
    {
        $penjualanSelesai = Penjualan::where('status_transaksi', '=', 'Selesai')->latest()->filter(request(['search_penjualan']))->paginate(20);

        return view('penjualan.indexPenjualanSelesai', [
            'penjualanSelesai' => $penjualanSelesai
        ]);
    }


    // menampilkan halaman detail transaksi penjualan yang dipilih
    public function show(Penjualan $penjualan)
    {
        $detailPenjualan = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->get();

        return view('penjualan.showPenjualan', [
            'penjualan' => $penjualan,
            'detailPenjualan' => $detailPenjualan,
        ]);
    }

    // Penjualan offline
    // menampilkan halaman pilih data pelanggan untuk membuat transaksi penjualan
    public function create()
    {
        $pelanggan = Pelanggan::filter(request(['search']))->paginate(15);
        return view('penjualan.createPenjualan', compact('pelanggan'));
    }

    // Penjualan offline
    // menyimpan data penjualan setelah memilih data pelanggan
    public function store(Request $request)
    {
        $tanggalHariIni = now()->format('Y-m-d');
        $nomorUrut = Penjualan::whereDate('created_at', $tanggalHariIni)->count();
        
        // dd($nomorUrut);

        $penjualan = new Penjualan();
        $penjualan->user_id = auth()->user()->id;
        $penjualan->nama_pelanggan = $request->nama_pelanggan;
        $penjualan->alamat_pelanggan = $request->alamat_pelanggan;
        $penjualan->telepon_pelanggan = $request->telepon_pelanggan;
        $penjualan->status_transaksi = 'Diproses';
        $penjualan->total_item = 0;
        $penjualan->total_harga = 0;
        $penjualan->diskon = 0;
        $penjualan->save();

        $penjualan->kode_penjualan = kodePenjualan(auth()->user()->level, auth()->user()->id, $nomorUrut);
        $penjualan->save();

        return redirect()->route('keranjangPenjualan', ['penjualan' => $penjualan->id])->with('success', 'Penjualan baru berhasil dibuat. Tambah barang pada nota.');
    }

    // Penjualan offline
    // menampilkan halaman seperti keranjang belanja untuk menambahkan barang ke data penjualan
    public function keranjangPenjualan(Penjualan $penjualan)
    {
        $barang = VarianBarang::filter(request(['search']))->paginate(5);
        $detailPenjualan = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->get();
        // $detailPenjualan = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->first();
        $hargaTotal = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->sum('sub_total');
        return view('penjualan.keranjangPenjualan', [
            'penjualan' => $penjualan,
            'detailPenjualan' => $detailPenjualan,
            'barang' => $barang, 
            'hargaTotal' => $hargaTotal
        ]);
    }

    // Penjualan online
    // proses transaksi penjualan dari pelanggan 
    public function prosesPenjualanPembeli(Penjualan $penjualan)
    {

        // dd($penjualan->detailPenjualan);
        $penjualan->status_transaksi = 'Diproses';
        $penjualan->save();

        foreach($penjualan->detailPenjualan as $dp)
        {
            $barangTerjual = new BarangTerjual;
            $barangTerjual->varian_barang_id = $dp->varian_barang_id;
            $barangTerjual->jumlah = $dp->jumlah_item;
            $barangTerjual->save();
        }

        
        if($penjualan->metode_pengiriman == 2){
            return back()->with('success', 'Transaksi diproses, masukan supir untuk pengiriman');
        }
        return back()->with('success', 'Transaksi diproses, barang diambil sendiri oleh pembeli');
    }

    public function tolakPenjualanPembeli(Penjualan $penjualan)
    {
        $penjualan->status_transaksi = 'Ditolak';
        $penjualan->save();

        return back()->with('delete', 'Transaksi ditolak');
    }

    // penjualan online
    // menyimpan data supir yang mengirim transaksi penjualan
    public function inputSupirPengirim(Request $request, Penjualan $penjualan)
    {
        // dd($request);
        $penjualan->supir = $request->supir;
        $penjualan->save();

        return back()->with('success', 'Supir untuk pengiriman telah ditambahkan');
    }

    public function kirim(Penjualan $penjualan)
    {
        $penjualan->status_transaksi = 'Dikirim';
        $penjualan->save();

        return back()->with('success', 'Penjualan Dikirim');
    }

    public function selesai(Penjualan $penjualan)
    {
        $penjualan->status_transaksi = 'Selesai';
        $penjualan->save();

        return back()->with('success', 'Transaksi Penjualan Selesai');
    }

    public function updateMetodePembayaranPengiriman(Request $request, Penjualan $penjualan)
    {
        // dd($penjualan->status_transaksi);

        $penjualan->metode_pembayaran = $request->metode_pembayaran;
        $penjualan->metode_pengiriman = $request->metode_pengiriman;
        $penjualan->status_transaksi = $request->status_transaksi;
        $penjualan->supir = $request->supir;
        $penjualan->status_pembayaran = 'Lunas';
        $penjualan->save();

        // dd($penjualan->detailPenjualan);
        foreach($penjualan->detailPenjualan as $dp)
        {
            $barangTerjual = new BarangTerjual;
            $barangTerjual->varian_barang_id = $dp->varian_barang_id;
            $barangTerjual->jumlah = $dp->jumlah_item;
            $barangTerjual->save();
        }

        return redirect()->route('showPenjualan', ['penjualan' => $penjualan->id])->with('success', 'Penjualan baru berhasil disimpan');
    }

    public function cetakNota(Penjualan $penjualan)
    {
    $detailPenjualan = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.notaPenjualan', compact('penjualan', 'detailPenjualan'))->setOptions(['defaultFont' => 'sans-serif']);;
        return $pdf->stream('notaPembelian.pdf');
    }

}

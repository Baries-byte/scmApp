<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\BarangMaster;
use App\Models\VarianBarang;
use Illuminate\Http\Request;
use App\Models\BarangTerjual;
use App\Models\PersediaanBarang;
use Illuminate\Support\Facades\DB;

class VarianBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //create
    public function create(BarangMaster $barangMaster){
        // dd($barangMaster);
        $supplier = Supplier::orderBy('nama_perusahaan')->get();
        $kategori = Kategori::orderBy('kategori')->get();
        $satuan = Satuan::orderBy('satuan')->get();
        return view('barang.varianBarang.createVarianBarang', ['supplier' => $supplier, 'satuan' => $satuan,'kategori' => $kategori, 'barangMaster' => $barangMaster]);
    }

    // store data
    public function store(Request $request){
        // dd($request);
        $request->validate(
            [
                'nama_varian_barang' => ['required', 'unique:varian_barang,nama_varian_barang'],
                'harga_beli' => 'required',
                'harga_jual' => 'required',
                // 'kode_produk' => 'required',
                'kategori_id' => 'required',
                'satuan_id' => 'required',
                'deskripsi' => 'required',
                'foto_barang' => 'image|mimes:jpeg,png,jpg|max:3072'
            ],
            [
                'nama_varian_barang.required' => 'Kolom nama barang harus diisi.',
                'nama_varian_barang.unique' => 'Nama barang yang diisi sudah ada.',
                'harga_beli.required' => 'Kolom harga beli harus diisi.',
                'harga_jual.required' => 'Kolom harga jual harus diisi.',
                // 'kode_produk.required' => 'Kolom kode produk harus diisi.',
                'kategori_id.required' => 'Kategori harus dipilih.',
                'satuan_id.required' => 'Supllier harus dipilih.',
                'deskripsi.required' => 'Kolom deskripsi harus diisi.',
                'foto_barang.image' => 'File harus berupa gambar',
                'foto_barang.mimes' => 'Tipe file yang diunggah harus JPEG, PNG, JPG, atau GIF.',
                'foto_barang.max' => 'Ukuran file tidak boleh melebihi 3MB.'
            ]
        );

        $barangBaru = new VarianBarang();
        $barangBaru->barang_master_id = $request->barang_master_id;
        $barangBaru->nama_varian_barang = $request->nama_varian_barang;
        $barangBaru->harga_beli = $request->harga_beli;
        $barangBaru->harga_jual = $request->harga_jual;
        // $barangBaru->kode_produk = $request->kode_produk;
        // $barangBaru->kode_barang = 0;
        $barangBaru->kategori_id = $request->kategori_id;
        $barangBaru->satuan_id = $request->satuan_id;
        $barangBaru->deskripsi = $request->deskripsi;
        
        if($request->hasFile('foto_barang')) {
            $barangBaru->foto = $request->file('foto_barang')->store('foto_barang_toko', 'public');
        }
        $barangBaru->save();
        
        // ambil kode supplier
        $barangMaster = BarangMaster::where('id', $request->barang_master_id)->first();
        
        $kodeSupplier = Supplier::where('id', $barangMaster->supplier_id)->first();
        $barangBaru->kode_barang = kodeBarang($kodeSupplier->kode_supplier, $barangBaru->kategori_id, $barangBaru->id);
        $barangBaru->save();


        // buat persediaan barang

        $persediaanBarang = new PersediaanBarang();
        $persediaanBarang->varian_barang_id = $barangBaru->id;
        $persediaanBarang->persediaan_min = 0;
        $persediaanBarang->persediaan_max = 0;
        $persediaanBarang->pembelian_optimal = 0;
        $persediaanBarang->jumlah = 0;
        $persediaanBarang->save();

        return redirect()->route('showBarangMaster', ['barang' => $request->barang_master_id])->with('success', 'Varian barang berhasil ditambah.');
    }

    // show detail
    public function show(VarianBarang $varianBarang)
    {
        // dd($varianBarang->detailPenjualan);
        $barangMaster = $varianBarang->barangMaster;
        // dd($barangMaster);
        return view('barang.varianBarang.showVarianBarang', ['varianBarang' => $varianBarang, 'barangMaster' => $barangMaster]);
    }

    // edit
    public function edit(VarianBarang $varianBarang)
    {
        $kategori = Kategori::orderBy('kategori')->get();
        $satuan = Satuan::orderBy('satuan')->get();
        return view('barang.varianBarang.editVarianBarang', ['varianBarang' => $varianBarang, 'kategori' => $kategori, 'satuan' => $satuan]);
    }

    public function update(VarianBarang $varianBarang, Request $request)
    {
        $formFields = $request->validate(
            [
                'nama_varian_barang' => ['required'],
                'harga_beli' => 'required',
                'harga_jual' => 'required',
                'kode_produk' => 'required',
                'kategori_id' => 'required',
                'satuan_id' => 'required',
                'deskripsi' => 'required',
                'foto_barang' => 'image|mimes:jpeg,png,jpg|max:3072'
            ],
            [
                'nama_varian_barang.required' => 'Kolom nama barang harus diisi.',
                'harga_beli.required' => 'Kolom harga beli harus diisi.',
                'harga_jual.required' => 'Kolom harga jual harus diisi.',
                'kode_produk.required' => 'Kolom kode produk harus diisi.',
                'kategori_id.required' => 'Kategori harus dipilih.',
                'satuan_id.required' => 'Supllier harus dipilih.',
                'deskripsi.required' => 'Kolom deskripsi harus diisi.',
                'foto_barang.image' => 'File harus berupa gambar',
                'foto_barang.mimes' => 'Tipe file yang diunggah harus JPEG, PNG, JPG, atau GIF.',
                'foto_barang.max' => 'Ukuran file tidak boleh melebihi 3MB.'
            ]
        );

        if($request->hasFile('foto_barang')) {
            $formFields['foto'] = $request->file('foto_barang')->store('foto_barang_toko', 'public');
        }
        
        $varianBarang->update($formFields);

        return back()->with('success', 'Data barang berhasil diubah.');
    }

    // Destroy
    public function destroy(VarianBarang $varianBarang)
    {
        //cek data barang digunakan dipembelian atau tidak
        if(count($varianBarang->detailPembelian) != 0)
        {
            return back()->with('info', 'Barang tidak bisa dihapus karena data barang digunakan');
        }
        //cek data barang digunakan dipenjualan atau tidak
        if(count($varianBarang->detailPenjualan) != 0)
        {
            return back()->with('info', 'Barang tidak bisa dihapus karena data barang digunakan');
        }

        $varianBarang->delete();
        return back()->with('delete', 'Barang berhasil dihapus');
    }

    // edit persediaan barang
    public function editPersediaanBarang(VarianBarang $varianBarang)
    {
        $persediaanBarang = $varianBarang->persediaan;
        return view('barang.varianBarang.editPersediaanBarang', ['varianBarang' => $varianBarang, 'persediaanBarang' => $persediaanBarang]);
    }
    
    // update persediaan barang
    public function updatePersediaanBarang(PersediaanBarang $persediaanBarang, Request $request)
    {
        // dd($persediaanBarang, $request);
        $persediaanBarang->jumlah = $request->persediaan;
        $persediaanBarang->persediaan_min = $request->persediaan_min;
        $persediaanBarang->persediaan_max = $request->persediaan_max;
        $persediaanBarang->pembelian_optimal = $request->pembelian_optimal;
        $persediaanBarang->update();

        return back()->with('success', 'Persediaan barang berhasil diubah');
    }

    // hitung EOQ
    public function hitungEOQ(VarianBarang $varianBarang, Request $request)
    {
        $permintaan = $request->permintaan;
        $biayaPembelian = $request->biaya_pembelian;
        $biayaPenyimpanan = $request->biaya_penyimpanan;

        // Hitung EOQ dengan helper
        $EOQ = hitungEOQ($permintaan, $biayaPembelian, $biayaPenyimpanan);
        $EOQ = ($EOQ - floor($EOQ) > 0.5 ? ceil($EOQ) : floor($EOQ));

        // dd($EOQ);

        // Hitung Berapa Kali Pembelian dengan EOQ
        $jumlahPembelian = $permintaan / $EOQ;
        $jumlahPembelian = floor($jumlahPembelian);

        $barangMaster = $varianBarang->barangMaster;
        // Format EOQ agar diambil
        // $jumlahPembelian = number_format($jumlahPembelian, 0);
        // $EOQ = number_format($EOQ, 1);
        // $EOQ = str_replace('.', ',', $EOQ);
        
        // dd($EOQ, $jumlahPembelian);
        // dd($permintaan, $biayaPembelian, $biayaPenyimpanan, $EOQ);

        return view('barang.varianBarang.showVarianBarang', [
            'varianBarang' => $varianBarang,
            'barangMaster' => $barangMaster,
            'permintaan' => $permintaan,
            'biayaPembelian' => $biayaPembelian,
            'biayaPenyimpanan' => $biayaPenyimpanan,
            'EOQ' => $EOQ,
            'jumlahPembelian' => $jumlahPembelian
        ]);
    }

    public function updatePembelianOptimal(VarianBarang $varianBarang, Request $request)
    {
        // dd($barang->persediaan->pembelian_optimal, $request->nilaiEOQ);
        $persediaanBarang = PersediaanBarang::where('varian_barang_id', $varianBarang->id)->first();

        $persediaanBarang->pembelian_optimal = $request->nilaiEOQ;
        $persediaanBarang->update();

        return back()->with('success', 'Jumlah pembelian optimal berhasil diperbarui');
    }

    // show varian barang untuk supplier
    public function showVarianBarangUntukSupplier(VarianBarang $varianBarang) 
    {
        return view('supplier.varianBarangToko.showVarianBarangToko', ['varianBarang' => $varianBarang]);
    }

    
    public function hitungSMA(VarianBarang $varianBarang)
    {
        // Ambil data penjualan barang dari tabel "barang_terjual"

        // Ambil Data 12 bulan untuk ditampilkan 
        $dataPenjualanBarangTampil = BarangTerjual::select('varian_barang_id',
        (DB::raw('MONTH(created_at) as bulan')),
        (DB::raw('YEAR(created_at) as tahun')),  
        (DB::raw('SUM(jumlah) as jumlah'))
        )
        ->where('varian_barang_id', '=', $varianBarang->id)
        ->groupBy('bulan', 'tahun', 'varian_barang_id')
        ->orderBy('tahun', 'desc')
        ->orderBy('bulan', 'desc')
        ->limit(12)
        ->get()
        ->reverse();

        // Ambil Data 12 bulan aja untuk perhitungan SMA
        $dataPenjualanBarang = BarangTerjual::select('varian_barang_id',
        (DB::raw('MONTH(created_at) as bulan')),
        (DB::raw('YEAR(created_at) as tahun')),  
        (DB::raw('SUM(jumlah) as jumlah'))
        )
        ->where('varian_barang_id', '=', $varianBarang->id)
        ->groupBy('bulan', 'tahun', 'varian_barang_id')
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
            return view('barang.varianBarang.showVarianBarang', [
                'barangMaster' => $varianBarang->barangMaster,
                'varianBarang' => $varianBarang,
                'dataPenjualanBarang' => $dataPenjualanBarangTampil,
                'totalSetahun' => $totalPenjualanSetahun,
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
        
        
        // dd($data, $sma, $smaBaru, $dataPrediksiSetahun, $dataAktualSmaPrediksi, $dataPrediksiSetahunFloat);
        
        $prediksiSMAFinal = array_merge($data, $smaBaru);
        $prediksiSMAFinalSliced = array_slice($prediksiSMAFinal,0, 12);
        $prediksiSMAFinalFloat = array_map('floatval', $prediksiSMAFinalSliced);
        $totalPrediksiSetahun = number_format(array_sum($prediksiSMAFinalFloat), 2);
        // dd($prediksiSMAFinalFloat);
        // dd(gettype($totalPrediksiSetahun));


        // dd($dataPrediksiSetahunFloat);

        return view('barang.varianbarang.showVarianBarang', [
            'barangMaster' => $varianBarang->barangMaster,
            'varianBarang' => $varianBarang,
            'dataPenjualanBarang' => $dataPenjualanBarangTampil,
            'totalSetahun' => $totalPenjualanSetahun,
            'dataPrediksiSMASetahun' => $prediksiSMAFinalFloat,
            'totalPrediksiSetahun' => $totalPrediksiSetahun
        ]);
    }

    public function hitungROP(VarianBarang $varianBarang, Request $request)
    {
        $kebutuhanSetahun = $request->kebutuhanSetahun;
        $waktuTunggu = $request->waktuTunggu;

        // hitung ROP dengan helper
        $ROP = hitungROP($kebutuhanSetahun, $waktuTunggu);
        $ROP = ($ROP - floor($ROP) > 0.5 ? ceil($ROP) : floor($ROP));

        // dd($ROP);

        return view('barang.varianBarang.showVarianBarang', [
            'varianBarang' => $varianBarang,
            'barangMaster' => $varianBarang->barangMaster,
            'kebutuhanSetahun' => $kebutuhanSetahun,
            'waktuTunggu' => $waktuTunggu,
            'ROP' => $ROP
        ]);
    }

    public function updatePersediaanMinimal(VarianBarang $varianBarang, Request $request)
    {
        // dd($barang->persediaan->pembelian_optimal, $request->nilaiEOQ);
        $persediaanBarang = PersediaanBarang::where('varian_barang_id', $varianBarang->id)->first();

        $persediaanBarang->persediaan_min = $request->nilaiROP;
        $persediaanBarang->update();

        return back()->with('success', 'Jumlah persediaan minimal berhasil diperbarui');
    }

    public function indexBarangKurangDariMinimal()
    {
        // $barang = Barang::whereRaw('persediaan <= persediaan_minimal')->get();

        $varianBarang = VarianBarang::join('persediaan_barang', 'varian_barang.id', '=', 'persediaan_barang.varian_barang_id')
        ->whereColumn('persediaan_barang.jumlah', '<', 'persediaan_barang.persediaan_min')
        ->paginate(15);
        // dd($varianBarang);

        return view('barang.indexBarangStokMinimal', compact('varianBarang'));
    }

    public function indexBarangKurangDariMinimalUntukSupplier()
    {
        $supplierId = auth()->user()->supplier->id;

        $barang = DB::table('barang_master')
            ->join('varian_barang', 'barang_master.id', '=', 'varian_barang.barang_master_id')
            ->join('persediaan_barang', 'varian_barang.id', '=', 'persediaan_barang.varian_barang_id')
            ->where('barang_master.supplier_id', $supplierId)
            ->whereColumn('persediaan_barang.jumlah', '<', 'persediaan_barang.persediaan_min')
            ->select('varian_barang.*', 'persediaan_barang.*')
            ->get();
        // dd($barang);

        return view('supplier.barangToko.indexBarangStokMinimal', compact('barang'));
    }

}

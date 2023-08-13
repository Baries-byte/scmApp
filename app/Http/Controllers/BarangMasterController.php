<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\BarangMaster;
use App\Models\VarianBarang;
use Illuminate\Http\Request;
use App\Models\BarangTerjual;
use App\Models\PersediaanBarang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BarangMasterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //Index
    public function index()
    {
        // $barang = BarangMaster::latest()->filter(request(['search']))->paginate(15);
        $barang = BarangMaster::latest()->get();
        return view('barang.barangMaster.indexBarangMaster', compact('barang'));
    }

    
    // Create (Show Create Form)
    public function create()
    {
        $supplier = Supplier::orderBy('nama_perusahaan')->get();
        $kategori = Kategori::orderBy('kategori')->get();
        return view('barang.barangMaster.createBarangMaster', compact('kategori', 'supplier'));
    }

    // Store
    public function store(Request $request)
    {
        // dd($request);
        $request->validate(
            [
                'nama_barang' => ['required', 'unique:barang_master,nama_barang'],
                'merek' => 'required',
                'supplier_id' => 'required',
                'kategori_id' => 'required',
            ],
            [
                'nama_barang.required' => 'Kolom nama barang harus diisi.',
                'nama_barang.unique' => 'Nama barang yang diisi sudah ada.',
                'merek.required' => 'Kolom merek harus diisi.',
                'supplier_id.required' => 'Supllier harus dipilih.',
                'kategori_id.required' => 'Kategori harus dipilih.',
            ]
        );

        $barangMasterBaru = new BarangMaster();
        $barangMasterBaru->nama_barang = $request->nama_barang;
        $barangMasterBaru->merek = $request->merek;
        $barangMasterBaru->supplier_id = $request->supplier_id;
        $barangMasterBaru->kategori_id = $request->kategori_id;
        $barangMasterBaru->save();

        // return redirect()->route('indexBarangMaster')->with('success', 'Barang master baru berhasil ditambahkan.');
        return redirect()->route('showBarangMaster', ['barang' => $barangMasterBaru->id])->with('success', 'Barang baru berhasil ditambah.');
    }

    // Show detail
    public function show(BarangMaster $barang)
    {
        // dd($barang->varianBarang);
        // $varianBarang = $barang->varianBarang;
        $varianBarang = VarianBarang::where('barang_master_id', $barang->id)->filter(request(['search']))->paginate(15);
        // dd($barang->varianBarang);
        // $varianBarang = $barang->varianBarang;
        return view('barang.barangMaster.showBarangMaster', [
            'barang' => $barang,
            'varianBarang' => $varianBarang
        ]);
    }

    
    // Edit
    public function edit(BarangMaster $barang)
    {
        $supplier = Supplier::orderBy('nama_perusahaan')->get();
        $kategori = Kategori::orderBy('kategori')->get();
        return view('barang.barangMaster.editBarangMaster', ['barang' => $barang, 'supplier' => $supplier, 'kategori' => $kategori]);
    }

    // Update
    public function update(Request $request, BarangMaster $barang)
    {
        $formFields = $request->validate(
            [
                'nama_barang' => ['required'],
                'merek' => 'required',
                'supplier_id' => 'required',
                'kategori_id' => 'required',
            ],
            [
                'nama_barang.required' => 'Kolom nama barang harus diisi.',
                'merek.required' => 'Kolom merek harus diisi.',
                'supplier_id.required' => 'Supllier harus dipilih.',
                'kategori_id.required' => 'Kategori harus dipilih.'
            ]
        );

        $barang->update($formFields);

        return back()->with('success', 'Data barang master berhasil diubah.');
    }

    // Destroy
    public function destroy(BarangMaster $barang)
    {
        if(count($barang->varianBarang) != 0)
        {
            return back()->with('info', 'Barang tidak bisa dihapus karena data barang digunakan');
        }

        $barang->delete();
        return redirect()->route('indexBarangMaster')->with('delete', 'Barang berhasil dihapus');
    }

    
    public function indexBarangMasterTokoUntukSupplier()
    {
        // $barangToko = auth()->user()->supplier->barangMaster;
        $barangToko = BarangMaster::where('supplier_id', auth()->user()->supplier->id)->filter(request(['search']))->paginate(15);

        // dd($barangToko);
        return view('supplier.barangToko.indexBarangMasterToko', [
            'barang' => $barangToko
        ]);
    }

    public function showBarangMasterTokoUntukSupplier(BarangMaster $barangMaster)
    {
        $varianBarang = VarianBarang::where('barang_master_id', $barangMaster->id)->filter(request(['search']))->paginate(15);
        return view('supplier.barangToko.showBarangMasterToko', [
            'barang' => $barangMaster,
            'varianBarang' => $varianBarang
        ]);
    }
    
//     public function indexBarangKurangDariMinimal()
//     {
//         // $barang = Barang::whereRaw('persediaan <= persediaan_minimal')->get();

//         $barang = Barang::join('persediaan_barang', 'barang.id', '=', 'persediaan_barang.barang_id')
//         ->whereColumn('persediaan_barang.jumlah', '<', 'persediaan_barang.persediaan_min')
//         ->paginate(15);
//         // dd($barang);

//         return view('barang.indexBarangStokMinimal', compact('barang'));
//     }

//     // Edit
//     public function edit(Barang $barang)
//     {
//         $supplier = Supplier::orderBy('nama_perusahaan')->get();
//         $kategori = Kategori::orderBy('kategori')->get();
//         return view('barang.editBarang', ['barang' => $barang, 'supplier' => $supplier, 'kategori' => $kategori]);
//     }

//     // Update
//     public function update(Request $request, Barang $barang)
//     {
//         $formFields = $request->validate(
//             [
//                 'nama_barang' => ['required'],
//                 'merek' => 'required',
//                 'supplier_id' => 'required',
//                 'kategori_id' => 'required',
//                 'deskripsi' => 'required',
//                 'harga_beli' => 'required',
//                 'harga_jual' => 'required',
//                 'satuan' => 'required',
//                 'foto_barang' => 'image|mimes:jpeg,png,jpg|max:3072'
//             ],
//             [
//                 'nama_barang.required' => 'Kolom nama barang harus diisi.',
//                 'merek.required' => 'Kolom merek harus diisi.',
//                 'supplier_id.required' => 'Supllier harus dipilih.',
//                 'kategori_id.required' => 'Kategori harus dipilih.',
//                 'deskripsi.required' => 'Kolom deskripsi harus diisi.',
//                 'harga_beli.required' => 'Kolom harga beli harus diisi.',
//                 'harga_jual.required' => 'Kolom harga jual harus diisi.',
//                 'satuan.required' => 'Kolom satuan harus diisi.',
//                 'foto_barang.image' => 'File harus berupa gambar',
//                 'foto_barang.mimes' => 'Tipe file yang diunggah harus JPEG, PNG, JPG, atau GIF.',
//                 'foto_barang.max' => 'Ukuran file tidak boleh melebihi 3MB.'
//             ]
//         );

//         if($request->hasFile('foto_barang')) {
//             $formFields['foto'] = $request->file('foto_barang')->store('foto_barang_toko', 'public');
//         }
        

//         $barang->update($formFields);

//         return back()->with('success', 'Data barang berhasil diubah.');
//     }

//     // Create (Show Create Form)
//     public function create()
//     {
//         $supplier = Supplier::orderBy('nama_perusahaan')->get();
//         $kategori = Kategori::orderBy('kategori')->get();
//         return view('barang.createBarang', compact('kategori', 'supplier'));
//     }

//     // Store
//     public function store(Request $request)
//     {
//         // dd($request->file('foto_barang'));
//         $request->validate(
//             [
//                 'nama_barang' => ['required', 'unique:barang,nama_barang'],
//                 'merek' => 'required',
//                 'supplier_id' => 'required',
//                 'kategori_id' => 'required',
//                 'deskripsi' => 'required',
//                 'harga_beli' => 'required',
//                 'harga_jual' => 'required',
//                 'satuan' => 'required',
//                 'foto_barang' => 'image|mimes:jpeg,png,jpg|max:3072'
//             ],
//             [
//                 'nama_barang.required' => 'Kolom nama barang harus diisi.',
//                 'nama_barang.unique' => 'Nama barang yang diisi sudah ada.',
//                 'merek.required' => 'Kolom merek harus diisi.',
//                 'supplier_id.required' => 'Supllier harus dipilih.',
//                 'kategori_id.required' => 'Kategori harus dipilih.',
//                 'deskripsi.required' => 'Kolom deskripsi harus diisi.',
//                 'harga_beli.required' => 'Kolom harga beli harus diisi.',
//                 'harga_jual.required' => 'Kolom harga jual harus diisi.',
//                 'satuan.required' => 'Kolom satuan harus diisi.',
//                 'foto_barang.image' => 'File harus berupa gambar',
//                 'foto_barang.mimes' => 'Tipe file yang diunggah harus JPEG, PNG, JPG, atau GIF.',
//                 'foto_barang.max' => 'Ukuran file tidak boleh melebihi 3MB.'
//             ]
//         );

//         $barangBaru = new Barang();
//         $barangBaru->nama_barang = $request->nama_barang;
//         $barangBaru->merek = $request->merek;
//         $barangBaru->supplier_id = $request->supplier_id;
//         $barangBaru->kategori_id = $request->kategori_id;
//         $barangBaru->deskripsi = $request->deskripsi;
//         $barangBaru->harga_beli = $request->harga_beli;
//         $barangBaru->harga_jual = $request->harga_jual;
//         $barangBaru->satuan = $request->satuan;
        
        
//         if($request->hasFile('foto_barang')) {
//             $barangBaru->foto = $request->file('foto_barang')->store('foto_barang_toko', 'public');
//         }
        
//         // ambil kode supplier
//         $kodeSupplier = Supplier::where('id', '=', $request->supplier_id)->first();
        
//         $barangBaru->save();
        
//         // buat kode barang
//         $barangBaru->kode_barang = kodeBarang($kodeSupplier->kode_supplier, $barangBaru->kategori_id, $barangBaru->id);
//         $barangBaru->save();

//         // buat persediaan barang baru
//         $persediaanBarangBaru = new PersediaanBarang();
//         $persediaanBarangBaru->barang_id = $barangBaru->id;
//         $persediaanBarangBaru->persediaan_min = 0;
//         $persediaanBarangBaru->persediaan_max = 0;
//         $persediaanBarangBaru->pembelian_optimal = 0;
//         $persediaanBarangBaru->jumlah = 0;
//         $persediaanBarangBaru->save();

        
//         // dd($barangBaru);

//         return redirect()->route('showBarang', ['barang' => $barangBaru->id])->with('success', 'Barang baru berhasil ditambah.');
//     }

//     // Show detail
//     public function show(Barang $barang)
//     {
//         return view('barang.showBarang', [
//             'barang' => $barang
//         ]);
//     }

//     // Destroy
//     public function destroy(Barang $barang)
//     {
//         if(count($barang->detailPenjualan) != 0)
//         {
//             return back()->with('info', 'Barang tidak bisa dihapus karena data barang digunakan');
//         }

//         $barang->delete();
//         return redirect()->route('indexBarang')->with('delete', 'Barang berhasil dihapus');
//     }

//     public function generateKodeBarang(Barang $barang)
//     {
//         if($barang->kode_barang != true)
//         {
//             $barang->kode_barang = kodeBarang($barang->supplier->kode_supplier, $barang->kategori_id, $barang->id);
//             $barang->save();
//             return back()->with('success', 'Kode barang berhasil dibuat');
//         }
        
//         return back()->with('info', 'Kode barang telah tersedia');
//     }


//     public function hitungSMA(Barang $barang)
//     {
//         // Ambil data penjualan barang dari tabel "barang_terjual"

//         // Ambil Data 12 bulan untuk ditampilkan 
//         $dataPenjualanBarangTampil = BarangTerjual::select('barang_id',
//         (DB::raw('MONTH(created_at) as bulan')),
//         (DB::raw('YEAR(created_at) as tahun')),  
//         (DB::raw('SUM(jumlah) as jumlah'))
//         )
//         ->where('barang_id', '=', $barang->id)
//         ->groupBy('bulan', 'tahun', 'barang_id')
//         ->orderBy('tahun', 'desc')
//         ->orderBy('bulan', 'desc')
//         ->limit(12)
//         ->get()
//         ->reverse();

//         // Ambil Data 12 bulan aja untuk perhitungan SMA
//         $dataPenjualanBarang = BarangTerjual::select('barang_id',
//         (DB::raw('MONTH(created_at) as bulan')),
//         (DB::raw('YEAR(created_at) as tahun')),  
//         (DB::raw('SUM(jumlah) as jumlah'))
//         )
//         ->where('barang_id', '=', $barang->id)
//         ->groupBy('bulan', 'tahun', 'barang_id')
//         ->orderBy('tahun', 'desc')
//         ->orderBy('bulan', 'desc')
//         ->get();

//         // Ambil data field jumlah lalu dijadikan array
//         $dataPenjualan = $dataPenjualanBarang->pluck('jumlah')->toArray();

//         // Balik data dari bulan terlama ke terakhir
//         // Karena data dari database diambil dari yg paling baru ke belakang
//         $data = array_reverse($dataPenjualan);

//         // Jika Datanya ada 12 bulan maka perhitungan SMA tidak dilakukan
//         // Bisa langsung digunakan untuk perhitungan EOQ

//         $totalPenjualanSetahun = $dataPenjualanBarangTampil->sum('jumlah');
        
//         if(count($data) >= 12)
//         {
//             return view('barang.showBarang', [
//                 'barang' => $barang,
//                 'dataPenjualanBarang' => $dataPenjualanBarangTampil,
//                 'totalSetahun' => $totalPenjualanSetahun,
//             ]);
//         }

//         // Perhitungan SMA
//         $periode = 3; // Periode SMA
//         $totalData = count($data);

//         $sma = []; // data perhitungan sma data penjualan

//         for ($i = 0; $i <= $totalData - $periode; $i++) {
//             $sma[] = array_sum(array_slice($data, $i, $periode)) / $periode;
//         }

//         $smaPrediksi[] = end($sma);
//         $dataAktualSmaPrediksi = array_merge($data, $smaPrediksi); // Data gabungan dari data penjualan dan $smaPrediksi untuk prediksi selama setahun

//         $smaBaru = [];

//         $totalData = 12;
        
//         for ($i = 0; $i <= $totalData - $periode; $i++) {

//             if(count($dataAktualSmaPrediksi) == $totalData)
//             {
//                 $dataAktualSmaPrediksi;
//             }
//             $smaBaru[] = array_sum(array_slice($dataAktualSmaPrediksi, $i, $periode)) / $periode;
//             $dataAktualSmaPrediksi[] = end($smaBaru);
//         }
        
//         $dataPrediksiSetahun = array_slice($dataAktualSmaPrediksi,0, 12);
//         // dd($dataPenjualanBarang, $dataPrediksiSetahun);
        
//         $dataPrediksiSetahunFloat = array_map('floatval', $dataPrediksiSetahun);
        
        
//         // dd($data, $sma, $smaBaru, $dataPrediksiSetahun, $dataAktualSmaPrediksi, $dataPrediksiSetahunFloat);
        
//         $prediksiSMAFinal = array_merge($data, $smaBaru);
//         $prediksiSMAFinalSliced = array_slice($prediksiSMAFinal,0, 12);
//         $prediksiSMAFinalFloat = array_map('floatval', $prediksiSMAFinalSliced);
//         $totalPrediksiSetahun = number_format(array_sum($prediksiSMAFinalFloat), 2);
//         // dd($prediksiSMAFinalFloat);
//         // dd(gettype($totalPrediksiSetahun));


//         // dd($dataPrediksiSetahunFloat);

//         return view('barang.showBarang', [
//             'barang' => $barang,
//             'dataPenjualanBarang' => $dataPenjualanBarangTampil,
//             'totalSetahun' => $totalPenjualanSetahun,
//             'dataPrediksiSMASetahun' => $prediksiSMAFinalFloat,
//             'totalPrediksiSetahun' => $totalPrediksiSetahun
//         ]);
//     }

//     public function hitungEOQ(Barang $barang, Request $request)
//     {
//         $permintaan = $request->permintaan;
//         $biayaPembelian = $request->biaya_pembelian;
//         $biayaPenyimpanan = $request->biaya_penyimpanan;

//         // Hitung EOQ dengan helper
//         $EOQ = hitungEOQ($permintaan, $biayaPembelian, $biayaPenyimpanan);
//         $EOQ = ($EOQ - floor($EOQ) > 0.5 ? ceil($EOQ) : floor($EOQ));

//         // dd($EOQ);

//         // Hitung Berapa Kali Pembelian dengan EOQ
//         $jumlahPembelian = $permintaan / $EOQ;
//         $jumlahPembelian = floor($jumlahPembelian);


//         // Format EOQ agar diambil
//         // $jumlahPembelian = number_format($jumlahPembelian, 0);
//         // $EOQ = number_format($EOQ, 1);
//         // $EOQ = str_replace('.', ',', $EOQ);
        
//         // dd($EOQ, $jumlahPembelian);
//         // dd($permintaan, $biayaPembelian, $biayaPenyimpanan, $EOQ);

//         return view('barang.showBarang', [
//             'barang' => $barang,
//             'permintaan' => $permintaan,
//             'biayaPembelian' => $biayaPembelian,
//             'biayaPenyimpanan' => $biayaPenyimpanan,
//             'EOQ' => $EOQ,
//             'jumlahPembelian' => $jumlahPembelian
//         ]);
//     }

//     public function editPersediaanBarang(Barang $barang)
//     {
//         $persediaanBarang = PersediaanBarang::where('barang_id', '=', $barang->id)->first();

//         // dd($barang, $persediaanBarang);

//         return view('barang.editPersediaanBarang', [
//             'barang' => $barang,
//             'persediaanBarang' => $persediaanBarang
//         ]);
//     }

//     public function updatePersediaanBarang(PersediaanBarang $persediaanBarang, Request $request)
//     {

//         // dd($persediaanBarang, $request);
//         $persediaanBarang->jumlah = $request->persediaan;
//         $persediaanBarang->persediaan_min = $request->persediaan_min;
//         $persediaanBarang->persediaan_max = $request->persediaan_max;
//         $persediaanBarang->pembelian_optimal = $request->pembelian_optimal;
//         $persediaanBarang->update();

//         return back()->with('success', 'Persediaan barang berhasil diubah');
//     }


//     public function indexBarangKurangDariMinimalUntukSupplier()
//     {
//         // $barang = Barang::whereRaw('persediaan <= persediaan_minimal')->get();

//         $barang = Barang::join('persediaan_barang', 'barang.id', '=', 'persediaan_barang.barang_id')
//         ->whereColumn('persediaan_barang.jumlah', '<', 'persediaan_barang.persediaan_min')
//         ->where('supplier_id', '=', auth()->user()->supplier->id)
//         ->get();
//         // dd($barang);

//         return view('supplier.barangToko.indexBarangStokMinimal', compact('barang'));
//     }



//     public function updatePembelianOptimal(Barang $barang, Request $request)
//     {

//         // dd($barang->persediaan->pembelian_optimal, $request->nilaiEOQ);
//         $persediaanBarang = PersediaanBarang::where('barang_id', $barang->id)->first();

//         $persediaanBarang->pembelian_optimal = $request->nilaiEOQ;
//         $persediaanBarang->update();

//         return back()->with('success', 'Jumlah pembelian optimal berhasil diperbarui');
//     }

}

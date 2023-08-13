<?php

namespace App\Http\Controllers;

use App\Models\BarangSupplier;
use App\Models\DetailPurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;

class PurchaseOrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //index purchase order
    public function index()
    {
        $purchaseOrder = PurchaseOrder::latest()->filter(request(['search']))->paginate(20);
    
        // dd($purchaseOrder);
        return view('purchaseOrder.indexPurchaseOrder', [
            'purchaseOrder' => $purchaseOrder
        ]);
    }

    public function create()
    {
        $supplier = Supplier::latest()->filter(request(['search']))->paginate(20);

        return view('purchaseOrder.createPurchaseOrder', [
            'supplier' => $supplier
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        // ambil tanggal hari ini dan nomor urut hari ini
        $tanggalHariIni = now()->format('Y-m-d');
        $nomorUrut = PurchaseOrder::whereDate('created_at', $tanggalHariIni)->count();


        $purchaseOrder = new PurchaseOrder();
        $purchaseOrder->supplier_id = $request->supplier_id;
        $purchaseOrder->total_item = 0;
        $purchaseOrder->total_harga = 0;
        $purchaseOrder->status = 'Aktif';
        $purchaseOrder->save();

        $supplier = Supplier::where('id', '=', $purchaseOrder->supplier_id)->first();
        $purchaseOrder->kode_purchase_order = kodePurchaseOrder($supplier->kode_supplier, auth()->user()->level, auth()->user()->id, $nomorUrut);
        $purchaseOrder->save();

        return redirect()->route('keranjangPurchaseOrder', ['purchaseOrder' => $purchaseOrder]);
    }

    public function keranjang(PurchaseOrder $purchaseOrder)
    {
        $barangSupplier = BarangSupplier::latest()->where('supplier_id', '=', $purchaseOrder->supplier_id)->paginate(5);
        $detailPurchaseOrder = DetailPurchaseOrder::where('purchase_order_id', '=', $purchaseOrder->id)->get();
        $totalHarga = DetailPurchaseOrder::where('purchase_order_id', '=', $purchaseOrder->id)->sum('sub_total');
        $totalItem = DetailPurchaseOrder::where('purchase_order_id', '=', $purchaseOrder->id)->sum('jumlah_item');

        $purchaseOrder->total_item = $totalItem;
        $purchaseOrder->total_harga = $totalHarga;
        $purchaseOrder->save();

        // dd($totalHarga);
        return view('purchaseOrder.keranjangPurchaseOrder', [
            'purchaseOrder' => $purchaseOrder,
            'barangSupplier' => $barangSupplier,
            'detailPurchaseOrder' => $detailPurchaseOrder,
            'totalHarga' => $totalHarga,
            'totalItem' => $totalItem
        ]);
    }
    
    public function show(PurchaseOrder $purchaseOrder)
    {
        if($purchaseOrder->status == 'Aktif')
        {
            return redirect()->route('keranjangPurchaseOrder', ['purchaseOrder' => $purchaseOrder->id]);
        }
        
        return view('purchaseOrder.showPurchaseOrder', [
            'purchaseOrder' => $purchaseOrder
        ]);
    }
    
    public function teruskanKePemilik(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->status = 'Menunggu konfirmasi pemilik';
        $purchaseOrder->save();
    
        return redirect()->route('indexPurchaseOrder')->with('success', 'Purchase Order diteruskan ke pemilik');
    }

    public function teruskanKeSupplier(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->status = 'Menunggu konfirmasi supplier';
        $purchaseOrder->save();

        return redirect()->route('indexPurchaseOrder')->with('success', 'Purchase Order diteruskan ke supplier');
    }

    public function batalkanPurchaseOrder(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->status = 'Dibatalkan';
        $purchaseOrder->save();

        return redirect()->route('indexPurchaseOrder')->with('success', 'Purchase Order dibatalkan');
    }


    // function untuk supplier

    public function indexPOSupplier()
    {
        // $purchaseOrder = auth()->user()->supplier->purchaseOrder->where('status', '!=', 'Aktif')
        // ->where('status', '!=', 'Menunggu konfirmasi pemilik')
        // ->where('status', '!=', 'Dibatalkan')
        // ->filter(request(['search']));

        $purchaseOrder = PurchaseOrder::where('supplier_id', '=', auth()->user()->supplier->id)
        ->where('status', '!=', 'Aktif')
        ->where('status', '!=', 'Menunggu konfirmasi pemilik')
        ->where('status', '!=', 'Dibatalkan')
        ->orderBy('created_at', 'desc')
        ->filter(request(['search']))
        ->paginate(15);

        return view('supplier.purchaseOrder.indexPurchaseOrderSupplier', ['purchaseOrder' => $purchaseOrder]);
    }

    public function showPOSupplier(PurchaseOrder $purchaseOrder)
    {
        return view('supplier.purchaseOrder.showPurchaseOrderSupplier', [
        'purchaseOrder' => $purchaseOrder
        ]);
    }

    public function tolakPOSupplier(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->status = 'Ditolak';
        $purchaseOrder->save();

        return back()->with('delete', 'Purchase Order ditolak');
    }

    // memproses PO dari toko
    public function prosesPOSupplier(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->status = 'Diproses';
        $purchaseOrder->save();

        return back()->with('success', 'Purchase Order diproses.');
    }

    public function prosesBuatPOSupplier(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->status = 'Diproses';
        $purchaseOrder->save();

        return redirect()->route('showPurchaseOrderSupplier', ['purchaseOrder' => $purchaseOrder])->with('success', 'Purchase Order diproses');
    }

    public function uploadSuratJalan(PurchaseOrder $purchaseOrder, Request $request)
    {
        $request->validate(
        [
            'surat_jalan' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:3072']
        ],
        [
            'surat_jalan.required' => 'File harus diisi',
            'surat_jalan.image' => 'File harus berupa gambar',
            'surat_jalan.mimes' => 'Tipe file yang diunggah harus JPEG, PNG, JPG, atau GIF.',
            'surat_jalan.max' => 'Ukuran file tidak boleh melebihi 3MB.'
        ]);

        $purchaseOrder->foto_surat_jalan = $request->file('surat_jalan')->store('surat_jalan', 'public');
        $purchaseOrder->status = 'Dikirim';
        $purchaseOrder->save();

        return back()->with('success', 'Surat Jalan berhasil ditambah. Status Purchase Order Dikirim');
    }

    public function uploadBuktiPenerimaan(PurchaseOrder $purchaseOrder, Request $request)
    {
        $request->validate(
        [
            'bukti_penerimaan' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:3072']
        ],
        [
            'bukti_penerimaan.required' => 'File harus diisi',
            'bukti_penerimaan.image' => 'File harus berupa gambar',
            'bukti_penerimaan.mimes' => 'Tipe file yang diunggah harus JPEG, PNG, JPG, atau GIF.',
            'bukti_penerimaan.max' => 'Ukuran file tidak boleh melebihi 3MB.'
        ]);

        $purchaseOrder->foto_bukti_penerimaan = $request->file('bukti_penerimaan')->store('bukti_penerimaan', 'public');
        $purchaseOrder->status = 'Selesai';
        $purchaseOrder->save();

        return back()->with('success', 'Bukti Penerimaan disimpan, purchase order selesai');
    }

    public function uploadInvoice(PurchaseOrder $purchaseOrder, Request $request)
    {
        $request->validate(
            [
                'invoice_pembelian' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:3072']
            ],
            [
                'invoice_pembelian.required' => 'File harus diisi',
                'invoice_pembelian.image' => 'File harus berupa gambar',
                'invoice_pembelian.mimes' => 'Tipe file yang diunggah harus JPEG, PNG, JPG, atau GIF.',
                'invoice_pembelian.max' => 'Ukuran file tidak boleh melebihi 3MB.'
            ]);

            $purchaseOrder->foto_invoice_pembelian = $request->file('invoice_pembelian')->store('invoice_pembelian', 'public');
            $purchaseOrder->save();

            return back()->with('success', 'Invoice Pembelian berhasil disimpan');
    }

    public function createPurchaseOrderSupplier()
    {
        if(auth()->user()->supplier->kerja_sama != 1)
        {
            return back()->with('info', 'Hanya supplier yang diizinkan yang dapat membuat purchase order');
        }
        
        $dataSupplier = auth()->user()->supplier;
        // dd($dataSupplier);

        // ambil tanggal hari ini dan nomor urut hari ini
        $tanggalHariIni = now()->format('Y-m-d');
        $nomorUrut = PurchaseOrder::whereDate('created_at', $tanggalHariIni)->count();


        $purchaseOrder = new PurchaseOrder();
        $purchaseOrder->supplier_id = $dataSupplier->id;
        $purchaseOrder->total_item = 0;
        $purchaseOrder->total_harga = 0;
        $purchaseOrder->status = 'Diproses';
        $purchaseOrder->save();

        $purchaseOrder->kode_purchase_order = kodePurchaseOrder($dataSupplier->kode_supplier, auth()->user()->level, auth()->user()->id, $nomorUrut);
        $purchaseOrder->save();

        return redirect()->route('keranjangPOSupplier', ['purchaseOrder' => $purchaseOrder->id])->with('success', 'Berhasil buat purchase order, masukan data barang');
    }

    public function keranjangPOSupplier(PurchaseOrder $purchaseOrder)
    {
        if(auth()->user()->supplier->kerja_sama != 1)
        {
            return back()->with('info', 'Hanya supplier yang diizinkan yang dapat membuat purchase order');
        }
        
        $barangSupplier = auth()->user()->supplier->barangSupplier;
        $detailPurchaseOrder = DetailPurchaseOrder::where('purchase_order_id', '=', $purchaseOrder->id)->get();
        $totalHarga = DetailPurchaseOrder::where('purchase_order_id', '=', $purchaseOrder->id)->sum('sub_total');
        $totalItem = DetailPurchaseOrder::where('purchase_order_id', '=', $purchaseOrder->id)->sum('jumlah_item');

        $purchaseOrder->total_item = $totalItem;
        $purchaseOrder->total_harga = $totalHarga;
        $purchaseOrder->save();

        return view('supplier.purchaseOrder.keranjangPurchaseOrderSupplier', [
            'purchaseOrder' => $purchaseOrder,
            'barangSupplier' => $barangSupplier,
            'detailPurchaseOrder' => $detailPurchaseOrder,
            'totalHarga' => $totalHarga,
            'totalItem' => $totalItem
        ]);
    }

    public function updateKodePOSupplierNomorSuratInvoice(PurchaseOrder $purchaseOrder, Request $request)
    {   
        $purchaseOrder->kode_purchase_order_supplier = $request->kode_surat;
        $purchaseOrder->save();
        // dd($purchaseOrder);

        return back()->with('success', 'Kode Surat berhasil diperbarui');
    }
}

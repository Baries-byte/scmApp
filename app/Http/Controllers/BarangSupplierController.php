<?php

namespace App\Http\Controllers;

use App\Models\BarangSupplier;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BarangSupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //index daftar barang supplier
    public function index()
    {
        $barangSupplier = BarangSupplier::where('supplier_id', auth()->user()->supplier->id)->filter(request(['search']))->paginate(15);
        return view('supplier.barang.indexBarangSupplier', ['barangSupplier' => $barangSupplier]);
    }

    public function create()
    {
        return view('supplier.barang.createBarangSupplier');
    }

    public function store(Request $request){
        // dd($request);

        $formFields = $request->validate([
            'nama_barang' => ['required', 'unique:barang_supplier,nama_barang'],
            'kode_barang' => 'required',
            'merek' => 'required',
            'harga_jual' => 'required',
            'deskripsi' => 'required',
            'supplier_id' => 'required',
            'foto_barang' => 'required|image|mimes:jpeg,png,jpg|max:3072'
        ], [
            'nama_barang.required' => 'Kolom nama barang harus diisi.',
            'nama_barang.unique' => 'Nama barang yang dimasukan telah terdaftar',
            'kode_barang.required' => 'Kolom kode barang harus diisi',
            'merek.required' => 'Kolom merek barang harus diisi',
            'harga_jual.required' => 'Kolom harga jual harus diisi',
            'deskripsi.required' => 'Kolom deskripsi harus diisi',
            'foto_barang.required' => 'Foto harus diisi',
            'foto_barang.image' => 'File harus berupa gambar',
            'foto_barang.mimes' => 'Tipe file yang diunggah harus JPEG, PNG, JPG, atau GIF.',
            'foto_barang.max' => 'Ukuran file tidak boleh melebihi 3MB.'
        ]);

        if($request->hasFile('foto_barang')) {
            $formFields['foto'] = $request->file('foto_barang')->store('foto_barang_supplier', 'public');
        }

        BarangSupplier::create($formFields);

        return redirect()->route('indexBarangSupplier')->with('success', 'Barang baru berhasil ditambahkan ');
    }

    public function show(BarangSupplier $barangSupplier){
        
        // check apakah supplier yang login adalah pemasok barang
        if($barangSupplier->supplier_id != auth()->user()->supplier->id){
            return redirect()->route('indexBarangSupplier');
        }
        
        return view('supplier.barang.showBarangSupplier', [
            'barangSupplier' => $barangSupplier
        ]);
    }

    public function edit(BarangSupplier $barangSupplier){
        return view('supplier.barang.editBarangSupplier', [
            'barangSupplier' => $barangSupplier
        ]);
    }

    public function update(BarangSupplier $barangSupplier, Request $request)
    {
        $formFields = $request->validate([
            'nama_barang' => ['required'],
            'kode_barang' => 'required',
            'merek' => 'required',
            'harga_jual' => 'required',
            'deskripsi' => 'required',
            'supplier_id' => 'required',
            'foto_barang' => 'image|mimes:jpeg,png,jpg|max:3072'
        ], [
            'nama_barang.required' => 'Kolom nama barang harus diisi.',
            'nama_barang.unique' => 'Nama barang yang dimasukan telah terdaftar',
            'kode_barang.required' => 'Kolom kode barang harus diisi',
            'merek.required' => 'Kolom merek barang harus diisi',
            'harga_jual.required' => 'Kolom harga jual harus diisi',
            'deskripsi.required' => 'Kolom deskripsi harus diisi',
            'foto_barang.image' => 'File harus berupa gambar',
            'foto_barang.mimes' => 'Tipe file yang diunggah harus JPEG, PNG, JPG, atau GIF.',
            'foto_barang.max' => 'Ukuran file tidak boleh melebihi 3MB.'
        ]);

        if($request->hasFile('foto_barang')) {
            $formFields['foto'] = $request->file('foto_barang')->store('foto_barang_supplier', 'public');
        }

        $barangSupplier->update($formFields);

        return back()->with('success', 'Data barang berhasil diubah');
    }

    public function destroy(BarangSupplier $barangSupplier){

        if(count($barangSupplier->detailPurchaseOrder) != 0)
        {
            return back()->with('info', 'Barang tidak bisa dihapus karena data barang digunakan');
        }
        $barangSupplier->delete();
        return redirect()->route('indexBarangSupplier')->with('delete', 'Barang berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\BarangSupplier;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $supplier = Supplier::latest()->paginate(20);
        return view('supplier.indexSupplier', compact('supplier'));
    }

    public function create()
    {
        $user = User::where('level', '3')->get();
        return view('supplier.createSupplier', compact('user'));
    }

    public function store(Request $request)
    {
        $formFields = $request->validate(
            [
                'nama_perusahaan' => ['required', 'unique:supplier,nama_perusahaan'],
                'alamat' => 'required',
                'telepon' => 'required',
                'email' => 'required',
            ],
            [
                'nama_perusahaan.required' => 'Kolom nama perusahaan supplier harus diisi.',
                'nama_perusahaan.unique' => 'Data supplier yang dimasukan sudah ada.',
                'telepon.required' => 'Kolom telepon harus diisi',
                'email.required' => 'Kolom email harus diisi', 
                'alamat.required' => 'Kolom alamat harus diisi.',
            ]
        );

        $formFields['kode_supplier'] = kodeSupplier($formFields['nama_perusahaan']);

        Supplier::create($formFields);

        return redirect()->route('indexSupplier')->with('success', 'Supplier baru berhasil ditambah.');
    }

    public function show(Supplier $supplier)
    {
        // $barangSupplier = BarangSupplier::where('supplier_id', '=', $supplier->id);
        return view('supplier.showSupplier', ['supplier' => $supplier]);
    }

    public function edit(Supplier $supplier)
    {
        $user = User::where('level', '3')->get();
        return view('supplier.editSupplier', [
            'supplier' => $supplier, 
            'user' => $user
        ]);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $formFields = $request->validate(
            [
                'nama_perusahaan' => 'required',
                'alamat' => 'required',
                'telepon' => 'required',
                'email' => 'required',
                'user_id' => 'required'
            ],
            [
                'nama_perusahaan.required' => 'Kolom nama perusahaan supplier harus diisi.',
                'telepon.required' => 'Kolom telepon harus diisi',
                'email.required' => 'Kolom email harus diisi', 
                'alamat.required' => 'Kolom alamat harus diisi.',
                'user_id.required' => 'Sales harus dipilih.'
            ]
        );


        $supplier->update($formFields);

        return back()->with('success', 'Data supplier berhasil diubah.');
    }

    public function destroy(Supplier $supplier)
    {
        if($supplier->barangSupplier == true)
        {
            return back()->with('info', 'Supplier tidak dapat dihapus karena data supplier digunakan');
        }
        $supplier->delete();
        return back()->with('delete', 'Supplier berhasil dihapus');
    }

    public function barangSupplier(Supplier $supplier)
    {
        $barangSupplier = BarangSupplier::where('supplier_id', '=', $supplier->id)->first();
        return view('supplier.barang.showBarangSupplier', ['barangSupplier' => $barangSupplier]);
    }

    public function generateKodeSupplier(Supplier $supplier)
    {
        $supplier->kode_supplier = kodeSupplier($supplier->nama_perusahaan);
        $supplier->save();

        return back()->with('success', 'Kode supplier berhasil dibuat');
    }

    public function kerjasamaDenganSupplier(Supplier $supplier)
    {
        $supplier->kerja_sama = 1;
        $supplier->save();

        return back()->with('success', 'Status kerjasama berhasil diubah, supplier diizinkan membuat purchase order');
    }
}

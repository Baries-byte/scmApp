<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Index
    public function index()
    {
        $kategori = Kategori::orderBy('kategori')->filter(request(['search']))->paginate(15);
        return view('kategori.indexKategori', compact('kategori'));
    }

    public function create(){
        return view('kategori.createKategori');
    }
    
    // Store Data
    public function store(Request $request)
    {
        // dd($request->all());
        $formFields = $request->validate(
            [
                'kategori' => ['required', 'unique:kategori,kategori']
            ],
            [
                'kategori.required' => 'Kolom kategori harus diisi',
                'kategori.unique' => 'Kategori yang dimasukan sudah ada'
            ]
        );
        Kategori::create($formFields);

        return redirect()->route('indexKategori')->with('success', 'Kategori baru berhasil ditambah');
    }

    // Destroy
    public function destroy(Kategori $kategori)
    {
        // cek dipakai di barang master atau tidak
        if(count($kategori->barangMaster) != 0){
            return back()->with('info', 'Kategori tidak dapat dihapus karena data kategori digunakan');
        }
        // cek dipakai di varian barang atau tidak
        if(count($kategori->varianBarang) != 0){
            return back()->with('info', 'Kategori tidak dapat dihapus karena data kategori digunakan');
        }
        
        $kategori->delete();
        return redirect()->route('indexKategori')->with('delete', 'Kategori berhasil dihapus.');
    }
}

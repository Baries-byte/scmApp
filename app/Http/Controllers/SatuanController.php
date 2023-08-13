<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //index
    public function index()
    {
        $satuan = Satuan::orderBy('satuan')->filter(request(['search']))->paginate(15);
        return view('satuan.indexSatuan', ['satuan' => $satuan]);
    }

    public function create(){
        return view('satuan.createSatuan');
    }

     // Store Data
    public function store(Request $request)
    {
         // dd($request->all());
        $formFields = $request->validate(
            [
                'satuan' => ['required', 'unique:satuan,satuan']
            ],
            [
                'satuan.required' => 'Kolom satuan harus diisi',
                'satuan.unique' => 'Satuan yang dimasukan sudah ada'
            ]
        );
        Satuan::create($formFields);

        return redirect()->route('indexSatuan')->with('success', 'Satuan baru berhasil ditambah');
    }

    public function destroy(Satuan $satuan)
    {
        // cek dipakai di varian barang atau tidak
        if(count($satuan->varianBarang) != 0){
            return back()->with('info', 'Satuan tidak dapat dihapus karena data satuan digunakan');
        }
        
        $satuan->delete();
        return redirect()->route('indexSatuan')->with('delete', 'Satuan berhasil dihapus.');
    }
}

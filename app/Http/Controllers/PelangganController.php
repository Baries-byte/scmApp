<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::latest()->filter(request(['search']))->paginate(20);

        return view('pelanggan.indexPelanggan', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.createPelanggan');
    }

    //store data pelanggan baru
    public function store(Request $request)
    {
        // dd($request);
        // validate form
        $this->validate($request, [
            'nama_pelanggan' => 'required',
            'alamat_pelanggan' => ['required', 'unique:pelanggan,alamat'],
            'telepon_pelanggan' => 'required',
        ], [
            'nama_pelanggan.required' => 'Kolom nama pelanggan harus diisi.',
            'alamat_pelanggan.required' => 'Kolom alamat pelanggan harus diisi.',
            'alamat_pelanggan.unique' => 'Data alamat pelanggan sama dengan data lain.',
            'telepon_pelanggan.required' => 'Kolom telepon pelanggan harus diisi.',
        ]);

        // store data
        $pelanggan = new Pelanggan();
        $pelanggan->nama = $request->nama_pelanggan;
        $pelanggan->alamat = $request->alamat_pelanggan;
        $pelanggan->telepon = $request->telepon_pelanggan;
        $pelanggan->save();

        return redirect()->route('indexPelanggan')->with('success', 'Data Pelanggan baru berhasil ditambahkan');
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.editPelanggan', [
            'pelanggan' => $pelanggan
        ]);
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $this->validate($request, [
            'nama_pelanggan' => 'required',
            'alamat_pelanggan' => 'required',
            'telepon_pelanggan' => 'required',
        ], [
            'nama_pelanggan.required' => 'Kolom nama pelanggan harus diisi.',
            'alamat_pelanggan.required' => 'Kolom alamat pelanggan harus diisi.',
            'telepon_pelanggan.required' => 'Kolom telepon pelanggan harus diisi.',
        ]);

        // store data
        $pelanggan->nama = $request->nama_pelanggan;
        $pelanggan->alamat = $request->alamat_pelanggan;
        $pelanggan->telepon = $request->telepon_pelanggan;
        $pelanggan->update();

        return back()->with('success', 'Data pelanggan berhasil diubah');
    }
    
    public function delete(Pelanggan $pelanggan) 
    {
        $pelanggan->delete();
        return back()->with('Pelanggan berhasil dihapus');
    }
}

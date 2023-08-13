<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\VarianBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index()
    {   
        // dd($request->kategori_id);
        $kategori = Kategori::get();
        $barang = VarianBarang::latest()->filter(request(['search', 'kategori_id']))->paginate(20);
        $transaksiPembelianAktif = false;

        // dd($barang);

        if(Auth::check()){
            $transaksiPembelianAktif = Penjualan::where('user_id', '=', auth()->user()->id)
                ->where('status_transaksi', '=', 'Aktif')
                ->first();

            // if($transaksiPembelianAktif == true){
            //     $adaTransaksiAktif = true;
            // }
            // dd($adaTransaksiAktif);

            return view('home', compact('barang', 'kategori', 'transaksiPembelianAktif'));
        };

        return view('home', compact('barang', 'kategori', 'transaksiPembelianAktif'));
    }

    public function detailBarangHome(VarianBarang $barang){
        $transaksiPembelianAktif = false;
        if(Auth::check()){
            $transaksiPembelianAktif = Penjualan::where('user_id', '=', auth()->user()->id)
                ->where('status_transaksi', '=', 'Aktif')
                ->first();

            // if($transaksiPembelianAktif == true){
            //     $adaTransaksiAktif = true;
            // }
            // dd($adaTransaksiAktif);

            return view('detailBarangHome', [
                'barang' => $barang,
                'transaksiPembelianAktif' => $transaksiPembelianAktif
            ]);
        };
        return view('detailBarangHome', [
            'barang' => $barang,
            'transaksiPembelianAktif' => $transaksiPembelianAktif
        ]);
    }

    public function createPelanggan(){
        return view('createPelanggan');
    }

    public function storePelanggan(Request $request){
        // dd($request);
        $formFields = $request->validate(
                [
                    'nama' => 'required',
                    'email' => ['required', 'email', 'unique:users,email'],
                    'alamat' => 'required',
                    'password' => ['required', 'confirmed', 'min:6'],
                    'telepon' => 'required',
                ],
                [
                    'nama.required' => 'Kolom nama harus diisi.',
                    'email.required' => 'Kolom email harus diisi.',
                    'email.unique' => 'Email sudah terdaftar.',
                    'alamat.required' => 'Kolom alamat harus diisi.',
                    'password.required' => 'Kolom password harus diisi.',
                    'password.confirmed' => 'konfirmasi Password berbeda.',
                    'password.min' => 'Password minimal 6 karakter.',
                    'telepon.required' => 'Kolom telepon harus diisi.',
                ]);

        // password hash
        $formFields['password'] = bcrypt($formFields['password']);

        User::create($formFields);

        return redirect()->route('home')->with('success', 'Anda berhasil terdaftar.');
    }
}

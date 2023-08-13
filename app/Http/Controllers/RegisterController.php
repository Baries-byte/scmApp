<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    // register pembeli
    public function registerPembeli()
    {
        return view('registerPembeli');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $formFields = $request->validate(
            [
                'nama' => 'required',
                'email' => ['required', 'email', 'unique:users,email'],
                'alamat' => 'required',
                'password' => ['required', 'confirmed', 'min:6'],
                'telepon' => 'required',
                'level' => 'required'
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
                'level.required' => 'Kolom level harus dipilih.'
            ]
        );

        // Password Hash
        $formFields['password'] = bcrypt($formFields['password']);

        // Create user
        User::create($formFields);

        if ($formFields['level'] == '0') {
            return redirect('/')->with('success', 'Anda berhasil terdaftar.');
        }

        return redirect('/user/create')->with('success', 'Akun baru berhasil dibuat.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function create()
    {
        return view('user.createUser');
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
        
        return back()->with('success', 'Akun baru berhasil dibuat.');
    }


    // menampilkan pegawai
    public function pegawai()
    {
        $pegawai = User::where('level', '2')->filter(request(['search']))->paginate(20);
        return view('user.indexUserPegawai', compact('pegawai'));
    }


    // menampilkan sales
    public function sales()
    {
        $sales = User::where('level', '3')->filter(request(['search']))->paginate(20);
        return view('user.indexUserSales', compact('sales'));
    }


    // menampilkan user pelanggan
    public function pelanggan()
    {
        $pelanggan = User::where('level', '0')->filter(request(['search']))->paginate(20);
        return view('user.indexUserPelanggan', compact('pelanggan'));
    }

    public function profileUser()
    {
        return view('user.profileUser');
    }

    public function editProfileUser()
    {
        return view('user.editProfileUser');
    }

    public function updateProfileUser(User $user, Request $request)
    {
        // dd($user);

        $formFields = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'email' => 'required'
        ], [
            'nama.required' => 'Kolom nama harus diisi.',
            'alamat.required' => 'Kolom alamat harus diisi.',
            'telepon.required' => 'Kolom telepon harus diisi.',
            'email.required' => 'Kolom email harus diisi.'
        ]);

        $user->update($formFields);

        return back()->with('success', 'Informasi profile berhasil diperbarui');
    }

    public function editPasswordUser()
    {
        return view('user.editPasswordUser');
    }

    public function updatePassword(User $user, Request $request)
    {
        // dd($user);
        $request->validate(
            [
                'password' => ['required', 'confirmed', 'min:6'],
            ],
            [
                'password.required' => 'Kolom password harus diisi.',
                'password.confirmed' => 'konfirmasi Password berbeda.',
                'password.min' => 'Password minimal 6 karakter.',
            ]);

        //hash password
        $newPassword = bcrypt($request->password);

        $user->password = $newPassword;
        $user->update();

        return back()->with('success', 'Password berhasil diubah.');
    }
}

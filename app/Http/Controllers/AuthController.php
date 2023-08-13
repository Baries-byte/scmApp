<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //login view
    public function login()
    {
        return view('login');
    }

    // autentikasi
    public function authentication(Request $request)
    {
        // dd($request);
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ], [
            'email.required' => 'Kolom email harus diisi.',
            'password.required' => 'Kolom password harus diisi.',
            'password.min' => 'Password minimal 6 karakter.'
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();

            if (auth()->user()->level !== 0) {
                return redirect('/dashboard')->with('success', 'Anda berhasil login.');
            }

            return redirect('/')->with('success', 'Anda berhasil login.');
        }

        return back()->withErrors([
            'email' => 'email atau password salah.'
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('delete', 'Anda berhasil logout.');
    }
}

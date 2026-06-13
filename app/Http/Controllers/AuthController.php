<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login admin
     */
    public function showLogin()
    {
        // Jika sudah login, jangan biarkan ke halaman login lagi, lempar ke dashboard
        if (Auth::check()) {
            return $this->redirectUserByRole(Auth::user());
        }

        return view('admin.login');
    }

    /**
     * Proses Login Admin
     */
public function login(Request $request): RedirectResponse
{
    // 1. Validasi standar
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // 2. Coba login tanpa syarat 'status'
    if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
        $request->session()->regenerate();
        return $this->redirectUserByRole(Auth::user());
    }

    // 3. Jika gagal, kirim pesan error yang jelas
    return back()->with('error', 'Email atau Password salah!');
}

    /**
     * Helper Fungsi untuk mengarahkan User berdasarkan Role
     */
    private function redirectUserByRole($user): RedirectResponse
    {
        if ($user->role === 'super_admin' || $user->role === 'admin_lab') {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended('/admin/dashboard');
    }

    /**
     * Proses Logout Bersama (Clear Session & Redirect Sesuai Asal)
     */
    public function logout(Request $request): RedirectResponse
    {
        // Cek dulu apakah yang sedang logout ini sebelumnya adalah Mahasiswa MyBioproses
        $isMahasiswa = $request->session()->get('user_type') === 'mahasiswa';

        Auth::logout();
        
        // Membersihkan semua data di sesi (termasuk session 'user_type' milik mahasiswa)
        $request->session()->invalidate();
        
        // Membuat token sesi baru agar tidak bisa dipakai ulang
        $request->session()->regenerateToken();

        // JALUR PENGALIHAN SETELAH LOGOUT:
        if ($isMahasiswa) {
            // Jika mahasiswa yang logout, kembalikan ke beranda utama
            return redirect('/')->with('success', 'Sesi MyBioproses Anda telah berakhir secara aman.');
        }

        // Jika admin yang logout, kembalikan ke halaman form login admin
        return redirect('/login')->with('success', 'Sesi Admin Anda telah berakhir secara aman.');
    }
}
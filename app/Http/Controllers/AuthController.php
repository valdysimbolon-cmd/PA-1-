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
        // 1. Validasi Input yang Lebih Ketat
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
        ], [
            'email.exists' => 'Email ini tidak terdaftar di sistem kami.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        // 2. Siapkan kredensial dan pastikan status user 'Aktif'
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
            'status'   => 'Aktif' 
        ];

        // 3. Eksekusi Login dengan fitur "Remember Me"
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            
            // Regenerasi Sesi: Membakar sesi lama, membuat yang baru agar tidak dibajak.
            $request->session()->regenerate();

            // Ambil data user yang login
            $user = Auth::user();

            // KUNCI UTAMA: Admin langsung didorong masuk ke dashboard admin tanpa mampir web utama!
            return $this->redirectUserByRole($user)
                   ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        // 4. Jika gagal: Jangan beri tahu secara spesifik mana yang salah (Email/Pass)
        return back()->withErrors([
            'email' => 'Kredensial salah atau akun Anda sedang dinonaktifkan.',
        ])->onlyInput('email');
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
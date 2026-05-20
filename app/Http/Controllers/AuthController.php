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
     * Proses Login
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
        // Ingat prinsip Feynman: Kita hanya menerima orang yang punya kartu akses aktif.
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

            // Berikan pesan sukses ke Dashboard
            return $this->redirectUserByRole($user)
                   ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        // 4. Jika gagal: Jangan beri tahu secara spesifik mana yang salah (Email/Pass)
        // Ini untuk mencegah 'Brute Force'
        return back()->withErrors([
            'email' => 'Kredensial salah atau akun Anda sedang dinonaktifkan.',
        ])->onlyInput('email');
    }

    /**
     * Helper Fungsi untuk mengarahkan User berdasarkan Role
     * Agar kode login lebih bersih (Clean Code)
     */
    private function redirectUserByRole($user): RedirectResponse
    {
        if ($user->role === 'super_admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->role === 'admin_lab') {
            // Pastikan kamu nanti membuat route dengan name 'lab.dashboard'
            return redirect()->intended(route('admin.dashboard')); 
        }

        return redirect()->intended('/admin');
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        
        // Membersihkan semua data di sesi
        $request->session()->invalidate();
        
        // Membuat token sesi baru agar tidak bisa dipakai ulang
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Sesi Anda telah berakhir secara aman.');
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('guest.mybioproses'); 
    }

public function login(Request $request)
{
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    try {
        $baseUrl = 'https://cis.del.ac.id';

        // Cookie jar agar cookie dari halaman login dipakai saat submit login
        $cookieJar = new \GuzzleHttp\Cookie\CookieJar();

        // 1. Buka halaman login CIS untuk ambil CSRF token
        $loginPage = Http::withOptions([
            'cookies' => $cookieJar,
            'verify' => false,
        ])->get($baseUrl . '/user/login');

        $html = $loginPage->body();

        // Ambil CSRF token dari input hidden Yii
        preg_match('/name="_csrf"\s+value="([^"]+)"/i', $html, $matches);

        $csrfToken = $matches[1] ?? null;

        if (!$csrfToken) {
            return back()->withErrors([
                'error' => 'CSRF token CIS tidak ditemukan.'
            ]);
        }

        // 2. Kirim form login ke CIS
        Http::asForm()
            ->withOptions([
                'cookies' => $cookieJar,
                'verify' => false,
                'allow_redirects' => true,
            ])
            ->post($baseUrl . '/user/login', [
                '_csrf' => $csrfToken,
                'LoginForm[username]' => $request->username,
                'LoginForm[password]' => $request->password,
            ]);

        // 3. Cek profil untuk memastikan login berhasil
        $profile = Http::withOptions([
            'cookies' => $cookieJar,
            'verify' => false,
        ])->get($baseUrl . '/user/profile');

        $profileHtml = $profile->body();

        // Jika masih diarahkan ke halaman login, berarti gagal
        if (
            str_contains(strtolower($profileHtml), 'loginform[username]') ||
            str_contains(strtolower($profileHtml), 'silakan masuk')
        ) {
            return back()->withErrors([
                'credentials' => 'Username atau password CIS salah.'
            ]);
        }

        // Simpan data minimal seperti kode pertama
        session([
            'pinjam_user' => [
                'username' => $request->username,
            ]
        ]);

        return redirect()->route('laboratorium.pinjam');

    } catch (\Exception $e) {
        Log::error('Login CIS gagal', [
            'message' => $e->getMessage(),
        ]);

        return back()->withErrors([
            'error' => 'Gagal menghubungi server CIS.'
        ]);
    }
}
    public function logout()
    {
        session()->forget(['pinjam_user', 'pinjam_token', 'pinjam_cookie']);
        return redirect()->route('login')->with('success', 'Berhasil keluar.');
    }

    // 1. Tampilan Login Admin (Gunakan view login standar Anda)
public function showAdminLogin()
{
    // Jika sudah login sebagai admin, langsung ke dashboard
    if (auth()->check() && in_array(auth()->user()->role, ['super_admin', 'admin_lab'])) {
        return redirect()->route('admin.dashboard');
    }

    // Jika sudah login sebagai mahasiswa, logout otomatis
    if (auth()->check()) {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        session()->flash('info', 'Anda telah logout otomatis untuk mengakses halaman login admin.');
    }

    // Sesuaikan dengan lokasi file view Anda
    return view('admin.login'); // <-- perhatikan ini
}
// 2. Logika Login Admin (Cek ke database lokal)
public function adminLogin(Request $request)
{
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    // Menggunakan Auth bawaan Laravel (cek tabel users)
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }

    return back()->withErrors(['email' => 'Kredensial admin tidak cocok.']);
}
// app/Http/Controllers/Auth/AuthController.php

public function logoutCis(Request $request)
{
    // Hapus session khusus mahasiswa CIS
    session()->forget(['pinjam_user', 'pinjam_token']);
    
    // Redirect ke halaman depan
    return redirect()->route('home')->with('success', 'Berhasil keluar dari akun MyBioproses.');
}
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\DomCrawler\Crawler; // Import library yang baru diinstall

class AuthController extends Controller
{
    // 1. TULISKAN URL DI SINI (Konstanta agar rapi)
    private const CIS_URL = 'https://cis.del.ac.id';

    public function showLogin()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }
        if (session()->has('pinjam_user')) {
            return redirect()->route('laboratorium.pinjam');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        if (str_contains($request->email, '@')) {
            return $this->loginAdmin($request);
        }

        return $this->loginMahasiswa($request);
    }

    private function loginMahasiswa(Request $request)
    {
        $username = $request->email; 
        $baseUrl  = self::CIS_URL; // Mengambil URL dari konstanta di atas

        try {
            $cookieJar = new CookieJar();

            // 2. Ambil Halaman Login CIS
            $loginPage = Http::withOptions([
                'cookies' => $cookieJar, 
                'verify' => false,
                'timeout' => 15 // Tambah timeout agar tidak cepat putus
            ])->get($baseUrl . '/user/login');

            // 3. Gunakan Crawler (Lebih profesional daripada preg_match)
            $crawler = new Crawler($loginPage->body());
            $csrfNode = $crawler->filter('input[name="_csrf"]');

            if ($csrfNode->count() === 0) {
                Log::warning('CSRF CIS tidak ditemukan. Struktur web CIS mungkin berubah.');
                return back()->withErrors(['email' => 'Gagal sinkronisasi dengan CIS.']);
            }

            $csrfToken = $csrfNode->attr('value');

            // 4. Proses Post Login
            Http::asForm()
                ->withOptions([
                    'cookies' => $cookieJar, 
                    'verify' => false, 
                    'allow_redirects' => true,
                    'timeout' => 15
                ])
                ->post($baseUrl . '/user/login', [
                    '_csrf'               => $csrfToken,
                    'LoginForm[username]' => $username,
                    'LoginForm[password]' => $request->password,
                ]);

            // 5. Cek Berhasil atau Tidak via Profile
            $profileHtml = Http::withOptions([
                'cookies' => $cookieJar, 
                'verify' => false,
                'timeout' => 15
            ])->get($baseUrl . '/user/profile')->body();

            if (str_contains(strtolower($profileHtml), 'loginform[username]') ||
                str_contains(strtolower($profileHtml), 'silakan masuk')) {
                return back()->withErrors(['email' => 'NIM atau password CIS salah.']);
            }

            // Simpan session
            session(['pinjam_user' => ['username' => $username]]);
            return redirect()->route('laboratorium.pinjam');

        } catch (\Exception $e) {
            // Ini akan mencatat error aslinya di storage/logs/laravel.log
            Log::error('Login CIS gagal', ['message' => $e->getMessage()]);
            return back()->withErrors(['email' => 'Gagal menghubungi server CIS. Pastikan Anda terhubung ke internet.']);
        }
    }

    private function loginAdmin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            $role = auth()->user()->role;

            if (in_array($role, ['super_admin', 'admin_lab'])) {
                return redirect()->route('admin.dashboard');
            }

            Auth::logout();
            return back()->withErrors(['email' => 'Akun Anda tidak memiliki akses.']);
        }

        return back()->withErrors(['email' => 'Email atau password tidak cocok.']);
    }

    public function logout(Request $request)
    {
        session()->forget(['pinjam_user', 'pinjam_token', 'pinjam_cookie']);

        if (auth()->check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login')->with('success', 'Berhasil keluar.');
    }

    public function logoutCis(Request $request)
    {
        session()->forget(['pinjam_user', 'pinjam_token']);
        return redirect()->route('login')->with('success', 'Berhasil keluar.');
    }
}
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Import Admin Controllers
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\LecturerController;
use App\Http\Controllers\Admin\CooperationController;
use App\Http\Controllers\Admin\CurriculumController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\ToolController;
use App\Http\Controllers\Admin\BorrowingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\LabController;
use App\Http\Controllers\Admin\DocumentArchiveController;
use App\Http\Controllers\Admin\FacilityController;

// ========================================================
// 1. JALUR PUBLIK (GUEST) - BISA DIAKSES SIAPA SAJA
// ========================================================
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/profil-bioproses', [PublicController::class, 'profilBioproses'])->name('guest.profil_bioproses');
Route::get('/dosen-staff', [PublicController::class, 'dosenStaff'])->name('public.dosen_staff');
Route::get('/staff-detail/{id}', [PublicController::class, 'lecturerDetail'])->name('public.staff.detail');
Route::get('/berita', [PublicController::class, 'news'])->name('public.news');
Route::get('/berita/{id}', [PublicController::class, 'showNews'])->name('public.news.show');
Route::get('/prestasi', [PublicController::class, 'prestasi'])->name('public.prestasi');
Route::get('/kurikulum', [PublicController::class, 'kurikulum'])->name('public.kurikulum');
Route::get('/pengumuman', [PublicController::class, 'announcements'])->name('public.announcements');
Route::get('/pengumuman/{id}', [PublicController::class, 'showAnnouncement'])->name('public.announcements.show');
Route::get('/dokumen', [PublicController::class, 'archives'])->name('public.archives');
Route::get('/unit-laboratorium', [PublicController::class, 'allLabs'])->name('public.labs');
Route::get('/unit-laboratorium/{slug}', [PublicController::class, 'showLab'])->name('public.lab.show');
Route::get('/ruangan-sarana', [PublicController::class, 'allFacilities'])->name('public.facilities');
Route::get('/mitra-kerjasama', [PublicController::class, 'allMitra'])->name('public.mitra.index');
Route::get('/mitra-detail/{id}', [PublicController::class, 'showMitra'])->name('public.mitra.show');
Route::get('/testimoni-alumni', [PublicController::class, 'allTestimonials'])->name('public.testimoni.index');
Route::get('/beasiswa', [PublicController::class, 'beasiswa'])->name('public.beasiswa');
Route::get('/testimoni-alumni/{id}', [PublicController::class, 'showTestimonial'])->name('public.testimoni.show');

// FIX: Menambahkan rute publik peminjaman alat agar tidak memicu error 404
Route::get('/peminjaman-alat', [PublicController::class, 'peminjamanAlat'])->name('public.peminjaman');

// ─── RUTE KHUSUS PORTAL MYBIOPROSES (DI LUAR ADMIN) ───
// Halaman Form Login & Register MyBioproses
Route::get('/mybioproses-login', function () {
    return view('guest.mybioproses');
})->name('mybioproses.auth');

// Proses Submit Login MyBioproses (Menggunakan Session Pembeda Role)
Route::post('/mybioproses-login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $request->session()->put('user_type', 'mahasiswa');
        
        return redirect('/');
    }

    return back()->withErrors([
        'email' => 'Email atau kata sandi yang Anda masukkan salah.',
    ])->withInput($request->only('email'));
})->name('mybioproses.login.submit');

// Mengarahkan proses register ke AuthController yang kita miliki
Route::post('/mybioproses-register', [AuthController::class, 'register'])->name('mybioproses.register.submit');


// ========================================================
// 2. JALUR AUTENTIKASI (GUEST ONLY) & LOGOUT INTEGRATED
// ========================================================
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Proses Logout menggunakan AuthController agar session dibersihkan secara total
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// ========================================================
// 3. JALUR ADMIN (WAJIB LOGIN)
// ========================================================
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Resource CRUD Admin
    Route::resource('profiles', ProfileController::class);
    Route::resource('cooperations', CooperationController::class);
    Route::resource('lecturers', LecturerController::class);
    Route::resource('news', NewsController::class);
    Route::resource('news_categories', NewsCategoryController::class); 
    Route::resource('announcements', AnnouncementController::class);
    Route::resource('achievements', AchievementController::class);
    Route::resource('labs', LabController::class);
    Route::resource('tools', ToolController::class);
    Route::resource('borrowings', BorrowingController::class);
    Route::resource('students', StudentController::class);
    Route::resource('document_archives', DocumentArchiveController::class);
    Route::resource('heroes', HeroController::class);
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('facilities', FacilityController::class);
    Route::resource('curriculums', CurriculumController::class);
Route::resource('subjects', SubjectController::class);
// Tambahkan baris ini di dalam group admin
Route::post('/curriculums/{curriculum}/semester/{semester}', [CurriculumController::class, 'updateSemester'])->name('curriculums.updateSemester');

Route::resource('curriculums', CurriculumController::class);
    Route::get('/beranda/edit', [ProfileController::class, 'index'])->name('beranda.edit');
    Route::get('/profil/edit', [ProfileController::class, 'index'])->name('profil.edit');
});
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| 1. CONTROLLERS IMPORTS
|--------------------------------------------------------------------------
*/

// Auth & Core
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Guest\UploadController;

// Guest - Beranda & Peminjaman
use App\Http\Controllers\Guest\Beranda\HomeController;
use App\Http\Controllers\Guest\Beranda\SearchController;
use App\Http\Controllers\LoanController; // Controller Peminjaman Mahasiswa

// Guest - Profil, Akademik, Kabar, Dokumen, Lab & Fasilitas
use App\Http\Controllers\Guest\Profil\ProfileController as GuestProfile;
use App\Http\Controllers\Guest\News_Information\CooperationController as GuestMitra;
use App\Http\Controllers\Guest\News_Information\TestimonialController as GuestTesti;
use App\Http\Controllers\Guest\Akademik\LecturerController as GuestLecturer;
use App\Http\Controllers\Guest\Akademik\CurriculumController as GuestCurriculum;
use App\Http\Controllers\Guest\Akademik\AchievementController as GuestAchievement;
use App\Http\Controllers\Guest\News_Information\InformationController as GuestInfo;
use App\Http\Controllers\Guest\Document\DocumentArchiveController as GuestArchive;
use App\Http\Controllers\Guest\Facility\LabController as GuestLab;
use App\Http\Controllers\Guest\Facility\FacilityController as GuestFacility;

// Admin Controllers
use App\Http\Controllers\Admin\Beranda\DashboardController;
use App\Http\Controllers\Admin\Beranda\HeroController;
use App\Http\Controllers\Admin\Profil\ProfileController;
use App\Http\Controllers\Admin\News_Information\InformationController;
use App\Http\Controllers\Admin\News_Information\CooperationController;
use App\Http\Controllers\Admin\News_Information\TestimonialController;
use App\Http\Controllers\Admin\Akademik\LecturerController;
use App\Http\Controllers\Admin\Akademik\CurriculumController;
use App\Http\Controllers\Admin\Akademik\AchievementController;
use App\Http\Controllers\Admin\Akademik\SubjectController;
use App\Http\Controllers\Admin\Document\DocumentArchiveController;
use App\Http\Controllers\Admin\Facility\LabController;
use App\Http\Controllers\Admin\Facility\ToolController;
use App\Http\Controllers\Admin\Facility\FacilityController;

// Admin Inventory & Loan (Sesuai folder inventory_loan)
use App\Http\Controllers\Admin\inventory_loan\InventoryController as AdminInventory;
use App\Http\Controllers\Admin\inventory_loan\LabLoanController as AdminLabLoan;
use App\Http\Controllers\Admin\inventory_loan\LoanActionController as AdminLoanAction;
use App\Http\Controllers\Admin\inventory_loan\ReportController as AdminReport;

/*
|--------------------------------------------------------------------------
| 2. PUBLIC / GUEST ROUTES
|--------------------------------------------------------------------------
*/

// Beranda & Search
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'search'])->name('public.search');

// Menu Profil, Akademik, Berita, Dokumen, Lab (Tanpa Login)
Route::get('/profil-bioproses', [GuestProfile::class, 'profilBioproses'])->name('guest.profil_bioproses');
Route::get('/beasiswa', [GuestProfile::class, 'beasiswa'])->name('public.beasiswa');
Route::get('/mitra-kerjasama', [GuestMitra::class, 'allMitra'])->name('public.mitra.index');
Route::get('/mitra-detail/{id}', [GuestMitra::class, 'showMitra'])->name('public.mitra.show');
Route::get('/testimoni-alumni', [GuestTesti::class, 'allTestimonials'])->name('public.testimoni.index');
Route::get('/testimoni-alumni/{id}', [GuestTesti::class, 'showTestimonial'])->name('public.testimoni.show');
Route::get('/dosen-staff', [GuestLecturer::class, 'dosenStaff'])->name('public.dosen_staff');
Route::get('/staff-detail/{id}', [GuestLecturer::class, 'lecturerDetail'])->name('public.staff.detail');
Route::get('/kurikulum', [GuestCurriculum::class, 'kurikulum'])->name('public.kurikulum');
Route::get('/prestasi', [GuestAchievement::class, 'prestasi'])->name('public.prestasi');
Route::get('/berita', [GuestInfo::class, 'news'])->name('public.news');
Route::get('/pengumuman', [GuestInfo::class, 'announcements'])->name('public.announcements');
Route::get('/berita/{id}', [GuestInfo::class, 'showInformation'])->name('public.news.show');
Route::get('/informasi/{id}', [GuestInfo::class, 'showInformation'])->name('public.information.show');
Route::get('/dokumen', [GuestArchive::class, 'archives'])->name('public.archives');
Route::get('/unit-laboratorium', [GuestLab::class, 'allLabs'])->name('public.labs');
Route::get('/unit-laboratorium/{id}', [GuestLab::class, 'showLab'])->name('public.lab.show');
Route::get('/ruangan-sarana', [GuestFacility::class, 'allFacilities'])->name('public.facilities');
Route::get('/fasilitas/{id}', [GuestFacility::class, 'showFacility'])->name('public.facility.show');

/*
|--------------------------------------------------------------------------
| 3. STUDENT LOAN ROUTES (GUEST/STUDENT WITH AUTH)
|--------------------------------------------------------------------------
*/

Route::middleware(['cis_auth'])->group(function () {
    
    // Rute Form Peminjaman
    Route::get('/laboratorium/pinjam', [App\Http\Controllers\Guest\Inventory_Loan\InventoryController::class, 'index'])
        ->name('laboratorium.pinjam');

    Route::post('/laboratorium/pinjam/simpan', [App\Http\Controllers\Guest\Inventory_Loan\LabLoanController::class, 'store'])
        ->name('pinjam.store');

    Route::get('/laboratorium/pinjam/sukses/{receipt}', [App\Http\Controllers\Guest\Inventory_Loan\LabLoanController::class, 'success'])
        ->name('guest.loan.success');

    // Cek status peminjaman
    Route::get('/laboratorium/cek-status', [App\Http\Controllers\Guest\Inventory_Loan\LabLoanController::class, 'checkStatus'])
        ->name('pinjam.status');

    // 🔽 TAMBAHKAN ROUTE CANCEL PEMINJAMAN (hanya untuk mahasiswa yang login)
    Route::post('/laboratorium/pinjam/batal/{labLoan}', [App\Http\Controllers\Guest\Inventory_Loan\LabLoanController::class, 'cancel'])
        ->name('guest.loan.cancel');

    Route::post('/logout-cis', [App\Http\Controllers\Auth\AuthController::class, 'logoutCis'])
        ->name('logout.cis');
});

/*
|--------------------------------------------------------------------------
| 4. AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/

// Portal MyBioproses (Login via CIS)
Route::get('/mybioproses-login', [AuthController::class, 'showLogin'])->name('mybioproses.auth');
Route::post('/mybioproses-login', [AuthController::class, 'login'])->name('mybioproses.login.submit');

// Admin Auth
Route::middleware(['guest'])->group(function () {
    // Rute untuk menampilkan form login admin
    Route::get('/login', [AuthController::class, 'showAdminLogin'])->name('login');

    // Rute untuk memproses data login admin
    Route::post('/login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| 5. ADMIN PANEL ROUTES (PROTECTED) — dengan middleware role
|--------------------------------------------------------------------------
*/

// ============================================================
// 5a. ROUTE YANG HANYA UNTUK SUPER ADMIN
// ============================================================
Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->group(function () {
    
    // Hero (banner utama)
    Route::resource('heroes', HeroController::class);
    
    // Profil institusi
    Route::resource('profiles', ProfileController::class);
    
    // Kerja sama mitra
    Route::resource('cooperations', CooperationController::class);
    
    // Testimoni
    Route::resource('testimonials', TestimonialController::class);
    
    // Berita & Pengumuman
    Route::resource('informations', InformationController::class);
    
    // Arsip Dokumen (kecuali download publik, yang ada di luar grup)
    Route::resource('document_archives', DocumentArchiveController::class)->except(['download']);
    // Download tetap bisa diakses publik dengan pengecekan di controller, tidak perlu di sini
    
    // Dosen & Staff
    Route::resource('lecturers', LecturerController::class);
    
    // Prestasi
    Route::resource('achievements', AchievementController::class);
    
    // Kurikulum & Mata Kuliah
    Route::resource('curriculums', CurriculumController::class);
    Route::resource('subjects', SubjectController::class);
    Route::post('/curriculums/{curriculum}/semester/{semester}', [CurriculumController::class, 'updateSemester'])
        ->name('curriculums.updateSemester');
    
    // Tools (jika masih digunakan)
    Route::resource('tools', ToolController::class);
});

// ============================================================
// 5b. ROUTE YANG BISA DIAKSES SUPER ADMIN & ADMIN LAB
// ============================================================
Route::middleware(['auth', 'role:super_admin,admin_lab'])->prefix('admin')->group(function () {
    
    // Dashboard (statistik)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Manajemen Laboratorium
    Route::resource('labs', LabController::class);
    
    // Manajemen Fasilitas
    Route::resource('facilities', FacilityController::class);
    
    // Manajemen Inventaris (alat & bahan lab)
    Route::resource('inventories', AdminInventory::class);
    Route::post('/inventories/{inventory}/toggle', [AdminInventory::class, 'toggleStatus'])
        ->name('inventories.toggle');
    
    // Verifikasi Peminjaman
    Route::get('/loans', [AdminLabLoan::class, 'adminIndex'])->name('admin.loans.index');
    Route::get('/loans/{labLoan}', [AdminLabLoan::class, 'adminShow'])->name('admin.loans.show');
    Route::post('/loans/{labLoan}/approve', [AdminLabLoan::class, 'approve'])->name('admin.loans.approve');
    Route::post('/loans/{labLoan}/reject', [AdminLabLoan::class, 'reject'])->name('admin.loans.reject');
    
    // Aksi Fisik (Barang Keluar & Kembali)
    Route::get('/handover', [AdminLoanAction::class, 'indexHandover'])->name('admin.handover.index');
    Route::post('/handover/{labLoan}', [AdminLoanAction::class, 'confirmHandover'])->name('admin.handover.confirm');
    Route::get('/return', [AdminLoanAction::class, 'indexReturn'])->name('admin.return.index');
    Route::post('/return/{labLoan}', [AdminLoanAction::class, 'confirmReturn'])->name('admin.return.confirm');
    
    // Laporan
    Route::get('/reports', [AdminReport::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/loan/pdf', [AdminReport::class, 'exportLoanPdf'])->name('admin.reports.loan.pdf');
    Route::get('/reports/inventory/pdf', [AdminReport::class, 'exportInventoryPdf'])->name('admin.reports.inventory.pdf');
});

// ============================================================
// 5c. UTILITY (Upload gambar untuk CKEditor) — 
//     Bisa diakses oleh semua admin yang sudah login
//     Namun tetap kita batasi hanya untuk super admin & admin lab
// ============================================================
Route::middleware(['auth', 'role:super_admin,admin_lab'])->prefix('admin')->group(function () {
    Route::post('/upload-image', [UploadController::class, 'upload'])->name('ckeditor.upload');
});

/*
|--------------------------------------------------------------------------
| 6. DOWNLOAD DOKUMEN (PUBLIC) — tetap di luar grup admin
|--------------------------------------------------------------------------
*/
Route::get('/document_archives/{documentArchive}/download', [DocumentArchiveController::class, 'download'])
    ->name('document_archives.download');
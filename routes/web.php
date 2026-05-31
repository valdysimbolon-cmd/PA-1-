<?php

use Illuminate\Support\Facades\Route;

// IMPORT SEMUA KONTROLER
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\LecturerController;
use App\Http\Controllers\Admin\CooperationController;
use App\Http\Controllers\Admin\CurriculumController;
use App\Http\Controllers\Admin\SubjectController;
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
// 1. JALUR PUBLIK (GUEST) - TANPA LOGIN
// ========================================================
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/profil-prodi', [PublicController::class, 'profile'])->name('public.profile');
Route::get('/berita', [PublicController::class, 'news'])->name('public.news');
Route::get('/berita/{id}', [PublicController::class, 'showNews'])->name('public.news.show');

// ========================================================
// 2. JALUR AUTENTIKASI (GUEST ONLY)
// ========================================================
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ========================================================
// 3. JALUR ADMIN (WAJIB LOGIN)
// ========================================================
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // RESOURCE CRUD
    Route::resource('profiles', ProfileController::class);
    Route::resource('cooperations', CooperationController::class);
    Route::resource('lecturers', LecturerController::class);
    Route::resource('curriculums', CurriculumController::class);
    Route::resource('subjects', SubjectController::class);
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

    // FIXING SIDEBAR OLD ROUTES
    Route::get('/beranda/edit', [ProfileController::class, 'index'])->name('beranda.edit');
    Route::get('/profil/edit', [ProfileController::class, 'index'])->name('profil.edit');
});
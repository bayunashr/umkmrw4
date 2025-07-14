<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UMKMApprovalController;
use App\Http\Controllers\DashboardController as UMKMDashboardController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUmkm;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Register Routes
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

/*
|--------------------------------------------------------------------------
| Approval Waiting Page
|--------------------------------------------------------------------------
*/
Route::get('/waiting-approval', function () {
    $user = auth()->user();

    if ($user->role === 0) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->profile && $user->profile->is_approved) {
        return redirect()->route('umkm.dashboard');
    }

    return view('auth.waiting');
})->middleware('auth')->name('approval.waiting');

/*
|--------------------------------------------------------------------------
| Global Dashboard Redirect
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 0) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 1) {
        if (!$user->profile || !$user->profile->is_approved) {
            return redirect()->route('approval.waiting');
        }
        return redirect()->route('umkm.dashboard');
    }

    abort(403, 'Role tidak dikenali');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', IsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/umkm', [AdminDashboardController::class, 'indexUmkm'])->name('umkm.index');
        Route::get('/umkm/create', [AdminDashboardController::class, 'createUmkm'])->name('umkm.create');
        Route::post('/umkm', [AdminDashboardController::class, 'storeUmkm'])->name('umkm.store');
        Route::get('/umkm/{profile:slug}', [AdminDashboardController::class, 'showUmkm'])->name('umkm.show');
        Route::get('/umkm/{profile:slug}/edit', [AdminDashboardController::class, 'editUmkm'])->name('umkm.edit');
        Route::put('/umkm/{profile:slug}', [AdminDashboardController::class, 'updateUmkm'])->name('umkm.update');

        Route::get('/approval', [UmkmApprovalController::class, 'index'])->name('approval');
        Route::get('/approval/{id}', [UMKMApprovalController::class, 'show'])->name('approval.show');
        Route::put('/approval/{id}/approve', [UMKMApprovalController::class, 'approve'])->name('approval.approve');
    });

/*
|--------------------------------------------------------------------------
| UMKM Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', IsUmkm::class])
    ->prefix('umkm')
    ->name('umkm.')
    ->group(function () {
        Route::get('/dashboard', [UMKMDashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

        Route::post('/profile/logo', [ProfileController::class, 'storeLogo'])->name('logo.store');
        Route::put('/profile/logo', [ProfileController::class, 'updateLogo'])->name('logo.update');
        Route::delete('/profile/logo', [ProfileController::class, 'destroyLogo'])->name('logo.destroy');

        Route::get('/profile/{profile:slug}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/{profile:slug}', [ProfileController::class, 'update'])->name('profile.update');

        Route::post('/profile/cover/store', [ProfileController::class, 'storeCover'])->name('cover.store');
        Route::put('/profile/cover/update', [ProfileController::class, 'updateCover'])->name('cover.update');
        Route::delete('/profile/cover/destroy', [ProfileController::class, 'destroyCover'])->name('cover.destroy');

        Route::get('/profile/password/change', [ProfileController::class, 'showChangePasswordForm'])->name('password.change');
        Route::put('/profile/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::get('/profile/password/forgot', [ProfileController::class, 'showForgotPasswordForm'])->name('password.forgot');

        Route::get('/product', [ProductController::class, 'index'])->name('product');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

        Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
        Route::get('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
        Route::get('/gallery/{id}', [GalleryController::class, 'show'])->name('gallery.show');
        Route::get('/gallery/{id}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
        Route::delete('/gallery/{id}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
    });

/*
|--------------------------------------------------------------------------
| Home Route
|--------------------------------------------------------------------------
*/
Route::get('/', [TestController::class, 'index'])->name('map.index');

// Route untuk search UMKM (AJAX)
Route::get('/api/search-umkm', [TestController::class, 'searchUmkm'])->name('api.search.umkm');

// Route untuk halaman profil UMKM
Route::get('/umkm/{slug}', [TestController::class, 'show'])->name('umkm.show');

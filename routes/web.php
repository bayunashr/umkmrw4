<?php

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

        // Tambahkan route UMKM lainnya di sini...
    });

/*
|--------------------------------------------------------------------------
| Home Route
|--------------------------------------------------------------------------
*/
Route::get('/', [TestController::class, 'index'])->name('home');

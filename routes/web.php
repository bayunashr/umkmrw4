<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUmkm;

// Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/waiting-approval', function () {
    return view('auth.waiting');
})->middleware('auth')->name('approval.waiting');

// Register
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');


// Dashboard
Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 0) {
        return redirect('/admin');
    } elseif ($user->role === 1) {
        return redirect('/umkm');
    }

    abort(403, 'Role tidak dikenali');
});

Route::middleware(['auth', IsAdmin::class])
    ->prefix('admin')
    ->name('admin.') // optional: supaya bisa pakai route('admin.dashboard')
    ->group(function () {
        Route::get('/', function () {
            return view('layouts.admin');
        })->name('dashboard');

        Route::get('/approval', [\App\Http\Controllers\Admin\UmkmApprovalController::class, 'index'])->name('approval');
        Route::get('/approval/{id}', [\App\Http\Controllers\Admin\UMKMApprovalController::class, 'show'])->name('approval.show');
        Route::put('/approval/{id}/approve', [\App\Http\Controllers\Admin\UMKMApprovalController::class, 'approve'])->name('approval.approve');
    });


Route::middleware(['auth', IsUmkm::class])
    ->prefix('umkm')
    ->name('umkm.')
    ->group(function () {
        Route::get('/', function () {
            $user = auth()->user();

            // Cek apakah profile sudah disetujui
            if (!$user->profile || !$user->profile->is_approved) {
                return redirect()->route('approval.waiting');
            }

            return view('layouts.umkm');
        })->name('dashboard');

        // Tambahkan route UMKM lainnya di sini
    });

Route::get('/', [\App\Http\Controllers\TestController::class,'index'])->name('home');

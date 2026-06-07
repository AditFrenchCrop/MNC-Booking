<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController; // Tambahkan ini
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HALAMAN UTAMA
Route::get('/', [BookingController::class, 'index'])->name('home');

// 2. KELOMPOK RUTE YANG WAJIB LOGIN
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/booking/{id}', [BookingController::class, 'show'])->name('booking.form');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 3. KELOMPOK RUTE KHUSUS ADMIN & SUPER ADMIN
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    Route::post('/admin/booking/{id}/approve', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/booking/{id}/reject', [AdminController::class, 'reject'])->name('admin.reject');

    // RUTE MANAJEMEN USER (Hanya untuk Super Admin)
    Route::middleware(['role:super_admin'])->group(function () {
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });
});

// 4. RUTE AUTENTIKASI BREEZE
require __DIR__.'/auth.php';
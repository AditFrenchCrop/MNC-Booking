<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HALAMAN UTAMA (Bisa dilihat oleh siapa saja, bahkan tanpa login)
// Menampilkan daftar studio MNC dan tombol "Booking Sekarang"
Route::get('/', [BookingController::class, 'index'])->name('home');


// 2. KELOMPOK RUTE YANG WAJIB LOGIN (Protected by 'auth' Middleware)
Route::middleware(['auth'])->group(function () {
    
    // Halaman Dashboard bawaan dari Laravel Breeze
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Halaman Form Booking (Hanya bisa dibuka jika sudah login)
    Route::get('/booking/{id}', [BookingController::class, 'show'])->name('booking.form');

    // Proses kirim data booking ke database (Hanya bisa dilakukan jika sudah login)
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

    // Rute bawaan Breeze untuk mengelola Profile Akun (Edit nama/password)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Pastikan kamu mengimpor AdminController di bagian paling atas file web.php jika belum ada:
// use App\Http\Controllers\AdminController;

// KELOMPOK RUTE KHUSUS ADMIN & SUPER ADMIN
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    
    // Halaman utama Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Tombol aksi approve & reject
    Route::post('/admin/booking/{id}/approve', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/booking/{id}/reject', [AdminController::class, 'reject'])->name('admin.reject');
});

// 3. FILE RUTE AUTENTIKASI BAWAAN BREEZE
// Mengaktifkan jalur otomatis untuk /login, /register, /logout, dll.
require __DIR__.'/auth.php';
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Studio; // Baris tambahan agar bisa membaca tabel Studio

class BookingController extends Controller
{
    // =========================================================================
    // 1. Fungsi Tambahan untuk MENAMPILKAN Daftar Studio di Halaman Utama (Welcome)
    // =========================================================================
    public function index()
    {
        // Mengambil semua data studio dari database mnc_booking
        $studios = Studio::all(); 
        
        // Melemparkannya ke view welcome.blade.php agar data tabel terisi
        return view('welcome', compact('studios'));
    }

    // =========================================================================
    // 2. Fungsi untuk MENAMPILKAN Form Booking Berdasarkan ID Studio yang Dipilih
    // =========================================================================
    public function show($id)
    {
        // Cari data studio berdasarkan ID yang diklik di halaman depan
        $studio = Studio::findOrFail($id);

        // Buka halaman form_booking.blade.php sambil membawa data studionya
        return view('form_booking', compact('studio'));
    }

    // =========================================================================
    // 3. Fungsi untuk MEMPROSES Simpan Data Booking (Kodingan Anti-Bentrok)
    // =========================================================================
    public function store(Request $request)
    {
        // 1. Ambil inputan dari form booking
        $studioId = $request->input('studio_id');
        $waktuMulai = $request->input('waktu_mulai');
        $waktuSelesai = $request->input('waktu_selesai');

        // 2. Cek apakah ada booking lain di studio yang sama dan jamnya bentrok
        $bentrok = Booking::where('studio_id', $studioId)
            ->where(function ($query) use ($waktuMulai, $waktuSelesai) {
                $query->where(function ($q) use ($waktuMulai, $waktuSelesai) {
                    // Skenario 1: Waktu mulai baru berada di antara booking yang sudah ada
                    $q->where('waktu_mulai', '<=', $waktuMulai)
                      ->where('waktu_selesai', '>', $waktuMulai);
                })
                ->orWhere(function ($q) use ($waktuMulai, $waktuSelesai) {
                    // Skenario 2: Waktu selesai baru berada di antara booking yang sudah ada
                    $q->where('waktu_mulai', '<', $waktuSelesai)
                      ->where('waktu_selesai', '>=', $waktuSelesai);
                })
                ->orWhere(function ($q) use ($waktuMulai, $waktuSelesai) {
                    // Skenario 3: Waktu baru memakan seluruh slot booking yang sudah ada
                    $q->where('waktu_mulai', '>=', $waktuMulai)
                      ->where('waktu_selesai', '<=', $waktuSelesai);
                });
            })->exists();

        // 3. Jika bentrok, balikin ke form dengan pesan peringatan merah
        if ($bentrok) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Maaf, studio sudah dibooking pada waktu tersebut. Silakan pilih waktu lain!');
        }

        // 4. Jika AMAN dari bentrok, baru simpan ke database mnc_booking
        $booking = new Booking();
        $booking->studio_id = $studioId;
        $booking->nama_peminjam = $request->nama_peminjam;
        $booking->waktu_mulai = $waktuMulai;
        $booking->waktu_selesai = $waktuSelesai;
        $booking->keperluan = $request->keperluan;
        $booking->save();

        // Diarahkan kembali ke halaman home dengan flash message sukses
        return redirect()->route('home')->with('success', 'Booking studio berhasil dicatat!');
    }
}
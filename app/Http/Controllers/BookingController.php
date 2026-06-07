<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Studio; 

class BookingController extends Controller
{
    // =========================================================================
    // 1. MENAMPILKAN Daftar Studio di Halaman Utama (Welcome)
    // =========================================================================
    public function index()
    {
        $studios = Studio::all(); 
        return view('welcome', compact('studios'));
    }

    // =========================================================================
    // 2. MENAMPILKAN Form Booking Berdasarkan ID Studio yang Dipilih
    // =========================================================================
    public function show($id)
    {
        $studio = Studio::findOrFail($id);
        
        // CARA 1 FIX: Diubah ke folder 'bookings'
        return view('bookings.form_booking', compact('studio'));
    }

    // =========================================================================
    // 3. MEMPROSES Simpan Data Booking (Anti-Bentrok)
    // =========================================================================
    public function store(Request $request)
    {
        $studioId = $request->input('studio_id');
        $waktuMulai = $request->input('waktu_mulai');
        $waktuSelesai = $request->input('waktu_selesai');

        // Cek bentrok jadwal
        $bentrok = Booking::where('studio_id', $studioId)
            ->where(function ($query) use ($waktuMulai, $waktuSelesai) {
                $query->where(function ($q) use ($waktuMulai, $waktuSelesai) {
                    $q->where('waktu_mulai', '<=', $waktuMulai)
                      ->where('waktu_selesai', '>', $waktuMulai);
                })
                ->orWhere(function ($q) use ($waktuMulai, $waktuSelesai) {
                    $q->where('waktu_mulai', '<', $waktuSelesai)
                      ->where('waktu_selesai', '>=', $waktuSelesai);
                })
                ->orWhere(function ($q) use ($waktuMulai, $waktuSelesai) {
                    $q->where('waktu_mulai', '>=', $waktuMulai)
                      ->where('waktu_selesai', '<=', $waktuSelesai);
                });
            })->exists();

        if ($bentrok) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Maaf, studio sudah dibooking pada waktu tersebut. Silakan pilih waktu lain!');
        }

        // Simpan data aman
        $booking = new Booking();
        $booking->user_id = auth()->id(); 
        $booking->studio_id = $studioId;
        $booking->nama_peminjam = $request->nama_peminjam;
        $booking->waktu_mulai = $waktuMulai;
        $booking->waktu_selesai = $waktuSelesai;
        $booking->keperluan = $request->keperluan;
        $booking->status = 'pending'; // Memastikan status awal terisi pending agar muncul di riwayat
        $booking->save();

        // FIX: Diubah dari 'home' ke 'dashboard' sesuai rute aktif proyekmu
        return redirect()->route('dashboard')->with('success', 'Booking studio berhasil dicatat!');
    }

    // =========================================================================
    // 4. TUGAS PERSON B: MENAMPILKAN Riwayat Booking Milik User yang Login
    // =========================================================================
    public function myBookings()
    {
        $bookings = Booking::with('studio')
            ->where('user_id', auth()->id())
            ->orderBy('waktu_mulai', 'asc')
            ->get();

        // CARA 1 FIX: Diubah dari 'my_booking' menjadi 'bookings.my_booking'
        return view('bookings.my_booking', compact('bookings'));
    }

    // =========================================================================
    // 5. TUGAS PERSON B: MEMBATALKAN / MENGHAPUS Data Booking
    // =========================================================================
    public function destroy($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $booking->delete();

        // FIX: Diarahkan langsung ke rute riwayat booking agar halaman segar kembali
        return redirect()->route('booking.my')->with('success', 'Booking studio berhasil dibatalkan!');
    }
}
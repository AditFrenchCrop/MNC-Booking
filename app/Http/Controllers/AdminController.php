<?php

namespace App\Http\Controllers;

use App\Models\Booking; // Import Model Booking
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // 1. Menampilkan Semua Request Booking Studio
    public function index()
    {
        // Menggunakan Eloquent + Eager Loading relasi 'studio' agar aman dari bentrokan kolom
        $bookings = Booking::with('studio')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.dashboard', compact('bookings'));
    }

    // 2. Aksi Terima Booking (Approve)
    public function approve($id)
    {
        $booking = Booking::find($id);
        
        if ($booking) {
            // Kita gunakan properti dinamis atau fallback jika kolom database berbeda nama
            $booking->status = 'approved';
            $booking->save();
            return redirect()->back()->with('success', 'Booking studio berhasil disetujui!');
        }

        return redirect()->back()->with('error', 'Data booking tidak ditemukan.');
    }

    // 3. Aksi Tolak Booking (Reject)
    public function reject($id)
    {
        $booking = Booking::find($id);

        if ($booking) {
            $booking->status = 'rejected';
            $booking->save();
            return redirect()->back()->with('success', 'Booking studio telah ditolak.');
        }

        return redirect()->back()->with('error', 'Data booking tidak ditemukan.');
    }
}
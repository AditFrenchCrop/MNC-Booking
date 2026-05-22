<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 1. Menampilkan Semua Request Booking Studio
    public function index()
    {
        // Mengambil semua data booking gabung dengan data nama studio
        $bookings = DB::table('bookings')
            ->join('studios', 'bookings::studio_id', '=', 'studios.id')
            ->select('bookings.*', 'studios.nama_studio')
            ->orderBy('bookings.created_at', 'desc')
            ->get();

        return view('admin.dashboard', compact('bookings'));
    }

    // 2. Aksi Terima Booking (Approve)
    public function approve($id)
    {
        DB::table('bookings')->where('id', $id)->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Booking studio berhasil disetujui!');
    }

    // 3. Aksi Tolak Booking (Reject)
    public function reject($id)
    {
        DB::table('bookings')->where('id', $id)->update(['status' => 'rejected']);
        return redirect()->back()->with('error', 'Booking studio telah ditolak.');
    }
}
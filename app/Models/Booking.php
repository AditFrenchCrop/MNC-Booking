<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    // Daftarkan kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'user_id',
        'studio_id',
        'nama_peminjam',
        'waktu_mulai',
        'waktu_selesai',
        'keperluan',
        'status', // Tambahkan ini untuk mengamankan kolom status
    ];

    // =========================================================================
    // RELASI: Setiap booking itu milik dari satu Studio (BelongsTo)
    // =========================================================================
    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class, 'studio_id');
    }

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
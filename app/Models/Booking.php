<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['studio_id', 'nama_peminjam', 'waktu_mulai', 'waktu_selesai', 'keperluan'];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalians';

    protected $fillable = [
        'peminjaman_id',
        'returned_by',
        'deskripsi_pengembalian',
        'foto_pengembalian',
        'tanggal_pengajuan_kembali',
        'tanggal_disetujui',
        'status_pengembalian',
    ];

    // Relasi ke peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    // Relasi ke user (admin) yang menyetujui pengembalian
    public function returnedBy()
    {
        return $this->belongsTo(User::class, 'returned_by');
    }
}

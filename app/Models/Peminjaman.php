<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';
    protected $fillable = [
        'users_id',
        'items_id',
        'jumlah_pinjam',
        'tanggal_pinjam',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function items()
    {
        return $this->belongsTo(Item::class, 'items_id');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id');
    }
}

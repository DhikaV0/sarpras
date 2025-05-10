<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'items_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];
    protected $table = 'peminjaman';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->belongsTo(Item::class);
    }
}

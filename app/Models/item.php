<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'stok',
        'category_id',
        'foto'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

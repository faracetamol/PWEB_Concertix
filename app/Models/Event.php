<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;

class Event extends Model
{
    protected $fillable = [
        'nama',
        'lokasi',
        'tanggal',
        'stok',
        'harga',
        'gambar',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'stok' => 'integer',
        'harga' => 'integer',
    ];

    public function scopeTerdekat($query)
    {
        return $query->orderBy('tanggal', 'asc');
    }

    public function kategoris()
    {
    return $this->belongsToMany(Kategori::class, 'event_kategori');
    }
}

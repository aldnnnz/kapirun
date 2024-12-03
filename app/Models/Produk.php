<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Kategori;
use App\Models\Toko;
use App\Models\RiwaiwayatStok;

class Produk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'produk';

    protected $fillable = [
        'kode',
        'nama_produk',
        'harga',
        'stok',
        'gambar',
        'id_kategori',
        'id_toko'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }
    public function riwayatStok()
    {
        return $this->hasMany(RiwayatStok::class, 'id_produk');
    }
}

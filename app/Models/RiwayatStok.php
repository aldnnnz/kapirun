<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Produk;
use App\Models\Pengguna;
use App\Models\Toko;

class RiwayatStok extends Model
{
    use SoftDeletes;

    protected $table = 'riwayat_stok';

    protected $fillable = [
        'id_produk',
        'perubahan_stok',
        'tipe',
        'harga_satuan',
        'id_pengguna',
        'id_toko'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Produk;
use App\Models\Toko;

class Kategori extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kategori';
    protected $fillable = ['nama_kategori', 'id_toko'];

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_kategori');
    }
}

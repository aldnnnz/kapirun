<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\RiwayatStok;
use App\Models\Transaksi;

class Toko extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'toko';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_toko', 'alamat_toko', 'telepon_toko', 'id_admin'];
    protected $dates = ['deleted_at'];

    public function produk(){
        return $this->hasMany(Produk::class);
    }

    public function admin(){
        return $this->belongsTo(Pengguna::class, 'id_admin');
    }
    public function riwayatStok()
    {
        return $this-> hasMany(RiwayatStok::class, 'id_toko');
    }
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_toko');
    }
    public function pengguna()
    {
        return $this->hasOne(Pengguna::class, 'id_toko');
    }
}

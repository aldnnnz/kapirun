<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;



class Pengguna extends Model implements AuthenticatableContract
{
    /** @use HasFactory<\Database\Factories\PenggunaFactory> */
    use HasFactory, HasApiTokens, Authenticatable, SoftDeletes;
    protected $table = 'pengguna';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nama',
        'email',
        'username',
        'password',
        'peran',
        'id_toko'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }

    public function transaksiKasir()
    {
        return $this->hasMany(Transaksi::class, 'id_kasir');
    }

    public function riwayatStok()
    {
        return $this->hasMany(RiwayatStok::class, 'id_pengguna');
    }
}

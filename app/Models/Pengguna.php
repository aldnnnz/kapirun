<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\authenticatable as authenticatableContract;
use Illuminate\Auth\Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Pengguna extends Model implements authenticatableContract
{
    /** @use HasFactory<\Database\Factories\PenggunaFactory> */
    use HasFactory, HasApiTokens, Authenticatable;
    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_hp',
    ];
}

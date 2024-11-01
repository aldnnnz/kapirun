<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    public function produk(){
        return $this->hasMany(Produk::class, 'category_id', 'id');
    }
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Kategori;
use App\Models\Toko;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'price', 'stock', 'store_id', 'category_id'];
    protected $dates = ['deleted_at'];

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'category_id', 'id');
    }
    public function toko(){
        return $this->belongsTo(Toko::class, 'store_id', 'id');
    }
    
}

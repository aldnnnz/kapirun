<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition()
    {
        return [
            'barcode' => $this->faker->unique()->ean13(),
            'nama_produk' => $this->faker->words(3, true),
            'harga' => $this->faker->randomFloat(2, 1000, 1000000),
            'stok' => $this->faker->numberBetween(0, 100),
            'gambar' => $this->faker->imageUrl(),
            'id_kategori' => Kategori::factory(),
        ];
    }
}
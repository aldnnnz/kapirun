<?php
namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class KategoriFactory extends Factory
{
    protected $model = Kategori::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->word(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
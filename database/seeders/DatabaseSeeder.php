<?php

namespace Database\Seeders;

// use App\Models\Pengguna;
use App\Models\Produk;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Produk::factory(10)->create();
        // Pengguna::factory(10)->create();

    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pengguna;
use App\Models\Toko;
use App\Models\Produk;
use App\Models\Pelanggan;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    

      Pengguna::factory(10)->create();
    
      Toko::factory(10)->create();
      Pelanggan::factory(10)->create();
      Produk::factory(10)->create();
      
    
    }
}

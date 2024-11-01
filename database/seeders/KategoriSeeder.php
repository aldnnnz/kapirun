<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['elektronik', 'fashion', 'makanan', 'minuman', 'peralatan rumah tangga', 'aksesoris'];
        
        foreach ($names as $name) {
            Kategori::create(['name' => $name]);
        }
    }
}

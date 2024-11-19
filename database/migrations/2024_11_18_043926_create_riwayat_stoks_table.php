<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_stok', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('id_produk')->constrained('produk', 'id');
            $table->integer('perubahan_stok');
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->decimal('harga_satuan', 10, 2);
            $table->foreignId('id_pengguna')->constrained('pengguna', 'id');
            $table->timestamps();    
            $table->softDeletes();
                
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_stok');
    }
};

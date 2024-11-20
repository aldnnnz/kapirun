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
            $table->id();
            $table->unsignedBigInteger('id_produk');
            $table->integer('perubahan_stok');
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->decimal('harga_satuan', 10, 2);
            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_toko');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_produk')->references('id')->on('produk')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('id_pengguna')->references('id')->on('pengguna')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('id_toko')->references('id')->on('toko')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
                
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

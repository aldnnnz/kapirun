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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_nota', 20);
            $table->unsignedBigInteger('id_kasir');
            $table->unsignedBigInteger('id_pelanggan')->nullable();
            $table->unsignedBigInteger('id_toko');
            $table->decimal('total', 10, 2);
            $table->decimal('jumlah_bayar', 10, 2);
            $table->decimal('kembalian', 10, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_kasir')->references('id')->on('pengguna')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('id_pelanggan')->references('id')->on('pelanggan')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
            $table->foreign('id_toko')->references('id')->on('toko')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            // Nomor nota unik per toko
            $table->unique(['nomor_nota', 'id_toko']);        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};

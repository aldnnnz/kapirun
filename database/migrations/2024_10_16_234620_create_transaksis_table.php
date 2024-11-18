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
            $table->id('id');
            $table->string('nomor_nota', 20)->unique();
            $table->unsignedBigInteger('id_kasir');
            $table->unsignedBigInteger('id_pelanggan')->nullable();
            $table->decimal('total', 10, 2);
            $table->decimal('jumlah_bayar', 10, 2);
            $table->decimal('kembalian', 10, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_kasir')->references('id')->on('pengguna');
            $table->foreign('id_pelanggan')->references('id')->on('pelanggan')->onDelete('set null');        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};

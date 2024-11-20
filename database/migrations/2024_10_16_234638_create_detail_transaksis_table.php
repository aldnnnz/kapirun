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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_transaksi');
            $table->unsignedBigInteger('id_produk');
            $table->integer('jumlah')->nullable(false);
            $table->decimal('harga_satuan', 10, 2)->nullable(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_transaksi')->references('id')->on('transaksi')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('id_produk')->references('id')->on('produk')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};

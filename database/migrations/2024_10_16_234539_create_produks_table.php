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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('barcode', 50)->unique();
            $table->string('nama_produk', 100);
            $table->decimal('harga', 10, 2);
            $table->integer('stok')->default(0);
            $table->string('gambar', 255)->nullable();
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_kategori')->references('id')->on('kategori');        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};

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
        Schema::create('toko', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko', 100)->nullable(false);
            $table->text('alamat_toko')->nullable(false);
            $table->string('telepon_toko', 15)->nullable();
            $table->unsignedBigInteger('id_pengguna')->unique()->nullable(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_pengguna')->references('id')->on('pengguna')->onDelete('cascade');        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toko');
    }
};

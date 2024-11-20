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
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan', 100)->nullable(false);
            $table->string('telepon', 15);
            $table->unsignedBigInteger('id_toko');
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('pelanggan');
    }
};
